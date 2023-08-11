package model;

import com.techelevator.authentication.PasswordHasher;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

@Component
public class JdbcStudentDao implements StudentDao {

    private JdbcTemplate jdbcTemplate;
    private PasswordHasher passwordHasher;

    /**
     * Create a new Student dao with the supplied data source and the password hasher
     * that will salt and hash all the passwords for Students.
     *
     * @param dataSource an SQL data source
     * @param passwordHasher an object to salt and hash passwords
     */
    @Autowired
    public JdbcStudentDao(DataSource dataSource, PasswordHasher passwordHasher) {
        this.jdbcTemplate = new JdbcTemplate(dataSource);
        this.passwordHasher = passwordHasher;
    }

    @Autowired
    private JdbcTeacherDao TeacherDao;
    @Autowired
    private JdbcClassDao ClassDao;

    public Student saveStudent(Long userId, String firstName, String lastName, LocalDate dateOfBirth, long phoneNumber, String email, long emergencyContact, String emergencyName, String insurance) {
        long newId = jdbcTemplate.queryForObject(
                "INSERT INTO Student(user_id, firstname, lastname, dob, phone, email, emergencyphone, emergencyname, insurance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING Student_id", Long.class,
                userId, firstName, lastName, dateOfBirth, phoneNumber, email, emergencyContact, emergencyName, insurance);

        Student newStudent = new Student();
        newStudent.setStudentId(newId);
        newStudent.setUserId(userId);
        newStudent.setFirstName(firstName);
        newStudent.setLastName(lastName);
        newStudent.setDateOfBirth(dateOfBirth);
        newStudent.setPhoneNumber(phoneNumber);
        newStudent.setEmail(email);
        newStudent.setEmergencyContact(emergencyContact);
        newStudent.setEmergencyName(emergencyName);
        newStudent.setInsurance(insurance);
        return newStudent;
    }

    /**
     * Look for a Student with the given Username and Password. Since we don't
     * know the password, we will have to get the Student's salt from the database,
     * hash the password, and compare that against the hash in the database.
     *
     * @param Username the user name of the Student we are checking
     * @param Password the password of the Student we are checking
     * @return true if the Student is found and their password matches
     */

    /**
     * Get all of the Student from the database.
     * @return a List of Student objects
     */

    @Override
    public List<Student> getAllStudents() {
        List<Student> Students = new ArrayList<Student>();
        String sqlSelectAllUsers = "SELECT id, user_name, role FROM app_user where role is 'Student' ;";

        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlSelectAllUsers);

        while (results.next()) {
            Student Student = mapResultToStudent(results);
            Students.add(Student);
        }

        return Students;
    }

    private Student mapResultToStudent(SqlRowSet results) {
        Student Student = new Student();
        Student.setStudentId(results.getLong("Student_id"));
        Student.setUserId(results.getLong("user_id"));
        Student.setFirstName(results.getString("firstname"));
        Student.setLastName(results.getString("lastname"));
        Student.setDateOfBirth(results.getDate("dob").toLocalDate());
        Student.setPhoneNumber(results.getLong("phone"));
        Student.setEmail(results.getString("email"));
        Student.setEmergencyContact(results.getLong("emergencyphone"));
        Student.setEmergencyName(results.getString("emergencyname"));
        Student.setInsurance(results.getString("insurance"));
        return Student;
    }

    public Student getOneStudent(Long userId){
        Student oneStudent = null;
        String sql = "Select * from Student where user_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, userId);
        while (result.next()){oneStudent = mapResultToStudent(result);}
        return oneStudent;
    }

    public Student getStudentByPid(Long StudentId){
        Student oneStudent = null;
        String sql = "Select * from Student where Student_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, StudentId);
        while (result.next()){oneStudent = mapResultToStudent(result);}
        return oneStudent;
    }

    public List<Student> getStudentsByTeacher(Long TeacherId) {
        List<Student> myStudents = new ArrayList<>();
        String sql = "SELECT * from Student join Student_Teacher pd on Student.Student_id = pd.Student_id where Teacher_id = ? order by lastname, firstname;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, TeacherId);
        while (results.next()) {
            myStudents.add(mapResultToStudent(results));
        }
        return myStudents;
    }

    public void updateStudent(Student Student) {
        String sqlUpdate = "UPDATE Student set firstname = ?, lastname = ?, dob = ?, phone = ?, email = ?, emergencyname = ?, emergencyphone = ?, insurance = ? where Student_id = ? or user_id = ?;";
        jdbcTemplate.update(sqlUpdate, Student.getFirstName(), Student.getLastName(), Student.getDateOfBirth(), Student.getPhoneNumber(), Student.getEmail(), Student.getEmergencyName(), Student.getEmergencyContact(), Student.getInsurance(), Student.getStudentId(), Student.getUserId());
    }

    public List<Student> getStudentsByAppointments(Long TeacherId){
        List<Long> bookedStudentIds = new ArrayList<>();
        String sql = "SELECT * from time_slot where Teacher_id = ? and date >= current_date;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, TeacherId);
        List<Class> ourAppointments = jdbcTemplate.query(sql, new JdbcClassDao.ClassRowMapper(), TeacherId);
        for (Class slot: ourAppointments) {
            if (!bookedStudentIds.contains(slot.getStudentId())){
                bookedStudentIds.add(slot.getStudentId());
            }
        }
        List<Student> bookedStudents = new ArrayList<>();
        for (Long pid: bookedStudentIds) {
            bookedStudents.add(getStudentByPid(pid));
        }
        return bookedStudents;
    }


}
