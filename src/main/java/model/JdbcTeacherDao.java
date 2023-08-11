package model;

import com.techelevator.authentication.PasswordHasher;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.util.ArrayList;
import java.util.List;

@Component
public class JdbcTeacherDao implements TeacherDao {

    private JdbcTemplate jdbcTemplate;
    private PasswordHasher passwordHasher;

    /**
     * Create a new Teacher dao with the supplied data source and the password hasher
     * that will salt and hash all the passwords for Teachers.
     *
     * @param dataSource an SQL data source
     * @param passwordHasher an object to salt and hash passwords
     */
    @Autowired
    public JdbcTeacherDao(DataSource dataSource, PasswordHasher passwordHasher) {
        this.jdbcTemplate = new JdbcTemplate(dataSource);
        this.passwordHasher = passwordHasher;
    }
    @Autowired
    public JdbcUserDao userDao;


    private Teacher mapResultToTeacher(SqlRowSet results) {
        Teacher Teacher = new Teacher();
        Teacher.setUserId(results.getLong("user_id"));
        Teacher.setTeacherId(results.getLong("Teacher_id"));
        Teacher.setCourseId(results.getLong("Course_id"));
        Teacher.setFirstName(results.getString("firstname"));
        Teacher.setLastName(results.getString("lastname"));
        Teacher.setSpecialty(results.getString("specialty"));
        return Teacher;
    }

    public void saveTeacher(Long UserId, Long CourseId, String firstName, String lastName, String specialty) {
        long newId = jdbcTemplate.queryForObject(
                "INSERT INTO Teacher(user_id, Course_id, firstname, lastname, specialty) VALUES (?, ?, ?, ?, ?) RETURNING Teacher_id", Long.class,
                UserId, CourseId, firstName, lastName, specialty);
        Teacher newTeacher = new Teacher();
        newTeacher.setTeacherId(newId);
        newTeacher.setUserId(UserId);
        newTeacher.setCourseId(CourseId);
        newTeacher.setFirstName(firstName);
        newTeacher.setLastName(lastName);
        newTeacher.setSpecialty(specialty);
    }

    @Override
    public List<Teacher> getAllTeachers() {
        List<Teacher> Teachers = new ArrayList<Teacher>();
        String sqlSelectAllUsers = "SELECT id, user_name, role FROM app_user where role = 'Teacher' ;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlSelectAllUsers);
        while (results.next()) {
            User user = userDao.mapResultToUser(results);
            Teacher Teacher = getOneTeacherByUserId(user.getId());
            Teachers.add(Teacher);
        }
        return Teachers;
    }

    public Teacher getOneTeacherByUserId(Long userId){
        Teacher oneTeacher = null;
        String sql = "Select * from Teacher where user_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, userId);
        while (result.next()){oneTeacher = mapResultToTeacher(result);}
        return oneTeacher;
    }

    public Teacher getTeacherByTeacherId(Long TeacherId){
        Teacher oneTeacher = null;
        String sql = "Select * from Teacher where Teacher_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, TeacherId);
        while (result.next()){oneTeacher = mapResultToTeacher(result);}
        return oneTeacher;
    }

    public List<Teacher> getTeachersByCourse(Long CourseId){
        List<Teacher> CourseTeachers = new ArrayList<>();
        String sql = "SELECT * from Teacher where Course_id = ?;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, CourseId);
        while (results.next()){
            CourseTeachers.add(mapResultToTeacher(results));
        }
        return CourseTeachers;
    }

    public void linkTeacherStudent(Long TeacherId, Long StudentId){
        String sql = "INSERT into Student_Teacher(Teacher_id, Student_id) values (?,?)";
        jdbcTemplate.update(sql, TeacherId, StudentId);
    }

    public void unlinkTeacherStudent(Long TeacherId, Long StudentId){
        String sql = "DELETE from Student_Teacher where Teacher_id = ? and Student_id = ?;";
        jdbcTemplate.update(sql, TeacherId, StudentId);
    }

    public Boolean isLinked(Long TeacherId, Long StudentId){
        String sql = "SELECT * from Student_Teacher where Teacher_id = ? and Student_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, TeacherId, StudentId);
        if (result.next()){return true;}
        else {return false;}
    }

    public List<Teacher> getTeachersByStudent(Long StudentId){
        List<Teacher> myTeachers = new ArrayList<>();
        String sql = "SELECT * from Teacher join Student_Teacher on Teacher.Teacher_id = Student_Teacher.Teacher_id where Student_id = ? order by lastname, firstname;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, StudentId);
        while (results.next()){
            myTeachers.add(mapResultToTeacher(results));
        }
        return myTeachers;
    }

    public void updateTeacher(Long TeacherId, String firstName, String lastName, String specialty, Long CourseId){
        String sql = "UPDATE Teacher set firstname = ?, lastname = ?, specialty = ?, Course_id = ? where Teacher_id = ?;";
        jdbcTemplate.update(sql, firstName, lastName, specialty, CourseId, TeacherId);
    }

    public void assignToCourse(Long TeacherId, Long CourseId){
        String sql = "UPDATE Teacher set Course_id = ? where Teacher_id = ?";
        jdbcTemplate.update(sql, CourseId, TeacherId);
    }
}
