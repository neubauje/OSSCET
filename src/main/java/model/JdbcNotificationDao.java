package model;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.util.ArrayList;
import java.util.List;

@Component
public class JdbcNotificationDao implements NotificationDao {

    private JdbcTemplate jdbcTemplate;

    @Autowired
    public JdbcNotificationDao(DataSource dataSource){
        this.jdbcTemplate = new JdbcTemplate(dataSource);
    }
    @Autowired
    private JdbcUserDao userDao;
    @Autowired
    private JdbcTeacherDao TeacherDao;
    @Autowired
    private JdbcStudentDao StudentDao;

    public List<Notification> getTeacherNewAlerts(Long TeacherId) {
        List<Notification> myNewAlerts = new ArrayList<>();
        String sql = "Select * from notification where Teacher_id = ? and acknowledged = false and intended_for_Teacher = true order by date_time;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, TeacherId);
        while (results.next()) {
            myNewAlerts.add(mapRowToNotification(results));
        }
        return myNewAlerts;
    }

    public List<Notification> getTeacherOldAlerts(Long TeacherId) {
        List<Notification> myOldAlerts = new ArrayList<>();
        String sql = "Select * from notification where Teacher_id = ? and acknowledged = true and intended_for_Teacher = true order by date_time desc limit 50;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, TeacherId);
        while (results.next()) {
            myOldAlerts.add(mapRowToNotification(results));
        }
        return myOldAlerts;
    }

    public List<Notification> getStudentNewAlerts(Long StudentId) {
        List<Notification> myNewAlerts = new ArrayList<>();
        String sql = "Select * from notification where Student_id = ? and acknowledged = false and intended_for_Teacher = false order by date_time;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, StudentId);
        while (results.next()) {
            myNewAlerts.add(mapRowToNotification(results));
        }
        return myNewAlerts;
    }

    public List<Notification> getStudentOldAlerts(Long StudentId) {
        List<Notification> myOldAlerts = new ArrayList<>();
        String sql = "Select * from notification where Student_id = ? and acknowledged = true and intended_for_Teacher = false order by date_time desc limit 50;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, StudentId);
        while (results.next()) {
            myOldAlerts.add(mapRowToNotification(results));
        }
        return myOldAlerts;
    }

    public Notification getNotifById(Long notifId){
        Notification alert = null;
        String sql = "SELECT * from notification where notif_id = ?;";
        SqlRowSet result = jdbcTemplate.queryForRowSet(sql, notifId);
        while (result.next()){
            alert = mapRowToNotification(result);
        }
        return alert;
    }

    public void createNotif(Long StudentId, Long TeacherId, String message, Boolean forTeacher) {
        String sql = "Insert into notification (Student_id, Teacher_id, contents, date_time, acknowledged, intended_for_Teacher) " +
                "values (?, ?, ?, localtimestamp, false, ?)";
        jdbcTemplate.update(sql, StudentId, TeacherId, message, forTeacher);
    }


    public void acknowledgeAlert(Notification alert){
      String sql = "Update notification SET acknowledged = true where notif_id = ?";
      jdbcTemplate.update(sql, alert.getNotifId());
    }


    private Notification mapRowToNotification(SqlRowSet alert) {
        Notification notif = new Notification();
        notif.setNotifId(alert.getLong("notif_id"));
        notif.setTeacherId(alert.getLong("Teacher_id"));
        notif.setStudentId(alert.getLong("Student_id"));
        notif.setContents(alert.getString("contents"));
        notif.setDateTime(alert.getTimestamp("date_time").toLocalDateTime());
        notif.setAcknowledged(alert.getBoolean("acknowledged"));
        notif.setIntendedForTeacher(alert.getBoolean("intended_for_Teacher"));
        return notif;
    }

    public String generateContentForTeacherCreate(Class appointment, Student Student){
        String content = "";
        content = content + Student.getFirstName() + " " + Student.getLastName();
        content = content + " booked an appointment with you for ";
        content = content + appointment.getDate() + " at " + appointment.getStartTime();
        return content;
    }

    public String generateContentForTeacherCancel(Class appointment, Student Student){
        String content = "";
        content = content + Student.getFirstName() + " " + Student.getLastName();
        content = content + " cancelled their appointment with you from ";
        content = content + appointment.getDate() + " at " + appointment.getStartTime();
        return content;
    }

    public String generateForTeacherDrop(Student Student){
        return Student.getFirstName() + " " + Student.getLastName() + " has decided not to be your Student anymore. Their appointments with you may need to be cancelled.";
    }

    public String generateContentForStudentCancel(Class appointment, Teacher Teacher){
        String content = "";
        content = content + Teacher.getFirstName() + " " + Teacher.getLastName();
        content = content + " cancelled your appointment on ";
        content = content + appointment.getDate() + " at " + appointment.getStartTime();
        return content;
    }

    public String generateContentForStudentUpdate(Class appointment, Teacher Teacher){
        String content = "";
        content = content + Teacher.getFirstName() + " " + Teacher.getLastName();
        content = content + " changed your appointment, it is now scheduled for ";
        content = content + appointment.getDate() + " at " + appointment.getStartTime();
        return content;
    }

    public String generateForStudentMoved(Class appointment, Teacher Teacher, Course oldCourse, Course newCourse){
        String content = "";
        content = content + "Your Teacher, " + Teacher.getFirstName() + " " + Teacher.getLastName();
        content = content + " has moved to a different location. Your appointment on " + appointment.getDate();
        content = content + " was previously located at " + oldCourse.getAddress() + ", but now it will be located at " + newCourse.getAddress() + ".";
        return content;
    }

    public String generateForStudentNameChange(Class appointment, Teacher oldTeacher, Teacher newTeacher){
        String content = "";
        content = content + "Your Teacher for your appointment on " + appointment.getDate();
        content = content + " has changed their name from " + oldTeacher.getFirstName() + " " + oldTeacher.getLastName();
        content = content + " to " + newTeacher.getFirstName() + " " + newTeacher.getLastName() + ". Make note of this for your check-in.";
        return content;
    }

    public boolean hasUnreadNotifs(Long userId){
        User user = userDao.getUserById(userId);
        String role = user.getRole();
        List<Notification> myAlerts = null;
        if (role.equals("Teacher")){
            Teacher Teacher = TeacherDao.getOneTeacherByUserId(userId);
            myAlerts = getTeacherNewAlerts(Teacher.getTeacherId());
        }
        else {
            Student Student = StudentDao.getOneStudent(userId);
           myAlerts = getStudentNewAlerts(Student.getStudentId());
        }
            if (myAlerts.size() > 0) {return true;}
            else {return false;}
    }
}
