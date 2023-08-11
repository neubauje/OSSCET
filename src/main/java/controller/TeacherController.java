package com.techelevator.controller;

import com.techelevator.authentication.AuthProvider;
import com.techelevator.model.Teacher.Teacher;
import com.techelevator.model.Teacher.JdbcTeacherDao;
import com.techelevator.model.Notification.JdbcNotificationDao;
import com.techelevator.model.Notification.Notification;
import com.techelevator.model.Office.JdbcOfficeDao;
import com.techelevator.model.Office.Office;
import com.techelevator.model.Patient.JdbcPatientDao;
import com.techelevator.model.Patient.Patient;
import com.techelevator.model.Review.JdbcReviewDao;
import com.techelevator.model.TimeSlot.JdbcTimeSlotDao;
import com.techelevator.model.TimeSlot.TimeSlot;
import com.techelevator.model.User.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;

import javax.servlet.http.HttpSession;
import java.util.List;

/**
 * SiteController
 */
@Controller
public class TeacherController {
    @Autowired
    private AuthProvider auth;
    @Autowired
    private JdbcTeacherDao TeacherDao;
    @Autowired
    private JdbcPatientDao patientDao;
    @Autowired
    private JdbcOfficeDao officeDao;
    @Autowired
    private JdbcReviewDao reviewDao;
    @Autowired
    private JdbcNotificationDao notificationDao;
    @Autowired
    private JdbcTimeSlotDao timeSlotDao;


    @RequestMapping(path = "/myPatients", method = RequestMethod.GET)
    public String loadMyPatients(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        Long TeacherId = Teacher.getTeacherId();
        List<Patient> mypatients = patientDao.getPatientsByTeacher(TeacherId);
        modelMap.addAttribute("patients", mypatients);
        return "LoggedIn/User/usedByTeachers/myPatients";
    }

    @RequestMapping(path = "/myPatients", method = RequestMethod.POST)
    public String selectPatient(ModelMap modelMap, @RequestParam Long patientId, HttpSession session){
        Patient patient = patientDao.getPatientByPid(patientId);
        modelMap.put("patient", patient);
        session.setAttribute("patient", patient);
        return "redirect:/patientDetails";
    }

    @RequestMapping(path = "/patientDetails", method = RequestMethod.GET)
    public String seePatientInfo(ModelMap modelMap, HttpSession session){
        Patient patient = (Patient) session.getAttribute("patient");
        modelMap.put("patient", patient);
        return "LoggedIn/User/usedByTeachers/patientDetails";
    }

    @RequestMapping(path = "/TeacherAlerts", method = RequestMethod.GET)
    public String loadDrAlerts(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        List<Notification> myNewAlerts = notificationDao.getTeacherNewAlerts(Teacher.getTeacherId());
        modelMap.addAttribute("newAlerts", myNewAlerts);
        List<Notification> myOldAlerts = notificationDao.getTeacherOldAlerts(Teacher.getTeacherId());
        modelMap.addAttribute("oldAlerts", myOldAlerts);
        return "LoggedIn/User/usedByTeachers/TeacherAlerts";
    }

    @RequestMapping(path = "/TeacherAlerts", method = RequestMethod.POST)
    public String acknowledgeDrAlert(@RequestParam Long notifId) {
        Notification alert = notificationDao.getNotifById(notifId);
        notificationDao.acknowledgeAlert(alert);
        return "redirect:/TeacherAlerts";
    }

    @RequestMapping(path = "/editTeacher", method = RequestMethod.GET)
    public String queryTeacher(HttpSession session, ModelMap modelMap){
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        modelMap.addAttribute("Teacher", Teacher);
        List<Office> officeList = officeDao.getAllOffices();
        modelMap.addAttribute("offices", officeList);
        return "LoggedIn/User/usedByTeachers/editTeacher";
    }

    @RequestMapping(path = "/editTeacher", method = RequestMethod.POST)
    public String updateTeacher(HttpSession session, @RequestParam String firstName, @RequestParam String lastName, @RequestParam String specialty, @RequestParam Long officeId){
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        Office oldOffice = officeDao.getOfficeById(Teacher.getOfficeId());
        Office newOffice = officeDao.getOfficeById(officeId);
        if (oldOffice.getOfficeId() != newOffice.getOfficeId()) {
            List<TimeSlot> myAppointments = timeSlotDao.seeMyAgenda(Teacher.getTeacherId());
            for (TimeSlot appointment: myAppointments) {
                String content = notificationDao.generateForPatientMoved(appointment, Teacher, oldOffice, newOffice);
                notificationDao.createNotif(appointment.getPatientId(), Teacher.getTeacherId(), content, false);
            }
        }
        TeacherDao.updateTeacher(Teacher.getTeacherId(), firstName, lastName, specialty, officeId);
        Teacher newTeacher = TeacherDao.getTeacherByTeacherId(Teacher.getTeacherId());
        if (!(Teacher.getFirstName().equals(newTeacher.getFirstName())) || !(Teacher.getLastName().equals(newTeacher.getLastName())))
        {
            List<TimeSlot> myAppointments = timeSlotDao.seeMyAgenda(Teacher.getTeacherId());
            for (TimeSlot appointment: myAppointments) {
                String content = notificationDao.generateForPatientNameChange(appointment, Teacher, newTeacher);
                notificationDao.createNotif(appointment.getPatientId(), Teacher.getTeacherId(), content, false);
            }
        }
        return "redirect:/private";
    }

}


