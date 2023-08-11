package model;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.util.ArrayList;
import java.util.List;
@Component
public class JdbcCourseDao implements CourseDao {


    private final JdbcTemplate jdbcTemplate;

    @Autowired
    public JdbcCourseDao(DataSource dataSource) {
       this.jdbcTemplate = new JdbcTemplate(dataSource);
    }

    public Course getCourse(String CourseName) {
        Course Course = null;
        String sqlGetCourse = "SELECT * FROM Course WHERE Course_name=?";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlGetCourse, CourseName);
        if (results.next()) {
            Course = mapRowToCourse(results);
        }
        return Course;
    }
    @Override
    public Course getCourseById(Long id) {
        Course Course = null;
        String sqlGetCourse = "SELECT * FROM Course WHERE Course_id=?";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlGetCourse, id);
        if (results.next()) {
            Course = mapRowToCourse(results);
        }
        return Course;
    }
    @Override
    public List<Course> getAllCourses() {
        List<Course> Courses = new ArrayList<>();
        String sqlGetAllCourses = "SELECT * FROM Course;";

        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlGetAllCourses);
        while (results.next()) {
            Course CourseResult = mapRowToCourse(results);
            Courses.add(CourseResult);
        }
        return Courses;
    }

    public List<Course> getAllRealCourses() {
        List<Course> Courses = new ArrayList<>();
        String sqlGetAllCourses = "SELECT * FROM Course where Course_id > 0 order by cost_per_hour;";

        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlGetAllCourses);
        while (results.next()) {
            Course CourseResult = mapRowToCourse(results);
            Courses.add(CourseResult);
        }
        return Courses;
    }

    @Override
    public void updateCourse(Course updatedCourse) {
        String sql = "UPDATE Course SET address = ?, opening_hours = ?, closing_hours = ?, " +
                "phone_number = ?, cost_per_hour = ? WHERE Course_id = ?;";
        jdbcTemplate.update(sql, updatedCourse.getAddress(), updatedCourse.getOpeningHours(),
                updatedCourse.getClosingHours(), updatedCourse.getPhoneNumber(),
                updatedCourse.getCostPerHour(), updatedCourse.getCourseId());
    }

    public List<Course> getCoursesByStudentId(Long StudentId){
        List<Course> myCourses = new ArrayList<>();
        String sql = "SELECT Course.Course_id, Course_name, address, days_open, opening_hours, closing_hours, phone_number, cost_per_hour from Course join Teacher d on Course.Course_id = d.Course_id join Student_Teacher pd on d.Teacher_id = pd.Teacher_id join Student p on p.Student_id = pd.Student_id where p.Student_id = ? group by Course.Course_id;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, StudentId);
        while (results.next()){
            myCourses.add(mapRowToCourse(results));
        }
        return myCourses;
    }

    private Course mapRowToCourse(SqlRowSet results) {
        Course Course = new Course();
        Course.setCourseId(results.getLong("Course_id"));
        Course.setCourseName(results.getString("Course_name"));
        Course.setAddress(results.getString("address"));
        Course.setDaysOpen(results.getString("days_open"));
        Course.setOpeningHours(results.getTime("opening_hours").toLocalTime());
        Course.setClosingHours(results.getTime("closing_hours").toLocalTime());
        Course.setPhoneNumber(results.getString("phone_number"));
        Course.setCostPerHour(results.getDouble("cost_per_hour"));
        return Course;
    }

    public Course createNewCourse(Course Course) {
        long CourseId = jdbcTemplate.queryForObject("INSERT into Course(Course_name, address, days_open, opening_hours, closing_hours, phone_number, cost_per_hour) values (?, ?, ?, ?, ?, ?, ?) returning Course_id", Long.class, Course.getCourseName(), Course.getAddress(), Course.getDaysOpen(), Course.getOpeningHours(), Course.getClosingHours(), Course.getPhoneNumber(), Course.getCostPerHour());
        Course.setCourseId(CourseId);
        return Course;
    }

}
