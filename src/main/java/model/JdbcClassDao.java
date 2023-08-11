package model;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.LocalTime;
import java.util.List;

@Component
public class JdbcClassDao implements ClassDao {
    private JdbcTemplate jdbcTemplate;
    Class Class = new Class();

    @Autowired
    public JdbcTeacherDao TeacherDao;
    @Autowired
    public JdbcStudentDao StudentDao;
    @Autowired
    public JdbcCourseDao CourseDao;

    @Autowired
    public JdbcClassDao(DataSource dataSource) {
        this.jdbcTemplate = new JdbcTemplate(dataSource);
    }

    public List<Class> findFreeSlots(LocalDate date, Long TeacherId) {
        String sqlGetAllClass = "Select *  from time_slot where (assigned = false AND Teacher_id=? AND date=?) order by date, start_time;";
        List<Class> Classs = jdbcTemplate.query(sqlGetAllClass, new ClassRowMapper(), TeacherId, date);
        return Classs;
    }

    public List<Class> findFreeSlots(Long TeacherId){
        String sqlGetAllClass = "Select *  from time_slot where (assigned = false AND Teacher_id = ?) and date >= current_date order by date, start_time limit 50;";
        List<Class> Classs = jdbcTemplate.query(sqlGetAllClass, new ClassRowMapper(), TeacherId);
        return Classs;
    }

    public List<Class> seeMyAppointments(Long StudentId) {
        String sqlGetAllClass = "Select *  from time_slot where assigned = true AND Student_id=? and date >= current_date order by date, start_time;";
        List<Class> Classs = jdbcTemplate.query(sqlGetAllClass, new ClassRowMapper(), StudentId);
        return Classs;
    }

    //Teacher will be able to see all the booked appointments by the using Teacher Id(As a Teacher)
    @Override
    public List<Class> seeMyAgenda(Long TeacherId) {
        String sqlGetAllClass = "Select *  from time_slot where (assigned = true AND Teacher_id=?) and date >= current_date ORDER BY date, start_time;";
        List<Class> Class = jdbcTemplate.query(sqlGetAllClass, new ClassRowMapper(), TeacherId);

        return Class;
    }

    public List<Class> seeMySchedule(Long TeacherId){
        String sqlGetAllClass = "Select *  from time_slot where Teacher_id = ? and date >= current_date ORDER BY date, start_time;";
        List<Class> Class = jdbcTemplate.query(sqlGetAllClass, new ClassRowMapper(), TeacherId);
        return Class;
    }

    public void createFreeSlot(long TeacherId, LocalDate date, LocalTime startTime, LocalTime endTime) {
        String sqlInsertClass = "Insert into time_slot( Teacher_id, date, start_time, end_time, assigned) VALUES (?,?,?,?,false)";
        jdbcTemplate.update(sqlInsertClass, TeacherId, date, startTime, endTime);
    }

    public Class updateClassByTeacher(LocalDate date, LocalTime startTime, LocalTime endTime) {
        String sql = "UPDATE time_slot SET date=?, start_time=?, end_time=?, description=? Where Class_id=?;";
        jdbcTemplate.update(sql, date, startTime, endTime);
        return Class;

    }

    public Class getClass(Long ClassId) {
        String sql = "Select * from time_slot where Class_id=? ";
        Class Class = jdbcTemplate.queryForObject(sql, new ClassRowMapper(), ClassId);
        return Class;
    }

    public Class updateAppointByStudent(Class Class) {
        String sql = "UPDATE time_slot SET Student_id = ?, assigned = true, description = ? where Class_id = ?";
        jdbcTemplate.update(sql, Class.getStudentId(), Class.getDescription(), Class.getClassId());
        return Class;
    }

    public void cancelAppointment(Class Class){
        String sql = "UPDATE time_slot SET Student_id = null, assigned = false, description = null where Class_id = ?";
        jdbcTemplate.update(sql, Class.getClassId());
    }

    public Class deleteClass(long ClassId) {

        String sql = "DELETE FROM time_slot WHERE Class_id = ?;";
        jdbcTemplate.update(sql, ClassId);
        return Class;


    }

    public static class ClassRowMapper implements RowMapper<Class> {

        @Override
        public Class mapRow(ResultSet rs, int i) throws SQLException {
            Class Class = new Class();
            Class.setClassId(rs.getLong("Class_id"));
            Class.setTeacherId(rs.getLong("Teacher_id"));
            Class.setDate(rs.getDate("date").toLocalDate());
            Class.setStartTime(rs.getTime("start_time").toLocalTime());
            Class.setEndTime(rs.getTime("end_time").toLocalTime());
            Class.setAssigned(rs.getBoolean("assigned"));
            Class.setStudentId(rs.getLong("Student_id"));
            Class.setDescription(rs.getString("description"));
            return Class;
        }
    }
}
