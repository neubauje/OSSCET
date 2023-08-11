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
import com.techelevator.model.User.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import javax.validation.Valid;
import java.util.List;

/**
 * SiteController
 */
@Controller
public class StudentController {
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

    @RequestMapping(path = "/findTeachers", method = RequestMethod.GET)
    public String showTeachers(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        Long patientId = patient.getPatientId();
        List<Teacher> TeacherList = TeacherDao.getAllTeachers();
        modelMap.addAttribute("Teachers", TeacherList);
        List<Office> officeList = officeDao.getAllOffices();
        modelMap.addAttribute("offices", officeList);
        List<Teacher> myTeachers = TeacherDao.getTeachersByPatient(patientId);
        modelMap.addAttribute("myTeachers", myTeachers);
        return "LoggedIn/User/usedByPatients/findTeachers";
    }

    @RequestMapping(path = "/findTeachers", method = RequestMethod.POST)
    public String pickTeacher(HttpSession session, @RequestParam Long TeacherId) {
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        Long patientId = patient.getPatientId();
        if (TeacherDao.isLinked(TeacherId, patientId)){TeacherDao.unlinkTeacherPatient(TeacherId, patientId);
        String content = notificationDao.generateForTeacherDrop(patient);
        notificationDao.createNotif(patientId, TeacherId, content, true);}
        else {TeacherDao.linkTeacherPatient(TeacherId, patientId);}
        return "redirect:/myTeachers";
    }

    @RequestMapping(path = "/myTeachers", method = RequestMethod.GET)
    public String loadMyTeachers(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        Long patientId = patient.getPatientId();
        List<Teacher> myTeachers = TeacherDao.getTeachersByPatient(patientId);
        modelMap.addAttribute("Teachers", myTeachers);
        List<Office> officeList = officeDao.getAllOffices();
        modelMap.addAttribute("offices", officeList);
        return "LoggedIn/User/usedByPatients/myTeachers";
    }

    @RequestMapping(path = "/myTeachers", method = RequestMethod.POST)
    public String bookMyTeacher(HttpSession session, @RequestParam Long TeacherId, ModelMap modelMap) {
        session.setAttribute("TeacherId", TeacherId);
        modelMap.addAttribute("TeacherId", TeacherId);
        Teacher Teacher = TeacherDao.getTeacherByTeacherId(TeacherId);
        session.setAttribute("Teacher", Teacher);
        modelMap.addAttribute("Teacher", Teacher);
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        Long patientId = patient.getPatientId();
        modelMap.addAttribute("patientId", patientId);
        return "redirect:/selectDate";
    }

    @RequestMapping(path = "/patientAlerts", method = RequestMethod.GET)
    public String loadDrAlerts(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        List<Notification> myNewAlerts = notificationDao.getPatientNewAlerts(patient.getPatientId());
        modelMap.addAttribute("newAlerts", myNewAlerts);
        List<Notification> myOldAlerts = notificationDao.getPatientOldAlerts(patient.getPatientId());
        modelMap.addAttribute("oldAlerts", myOldAlerts);
        return "LoggedIn/User/usedByPatients/patientAlerts";
    }

    @RequestMapping(path = "/patientAlerts", method = RequestMethod.POST)
    public String acknowledgeDrAlert(HttpSession session, @RequestParam Long notifId) {
        Notification alert = notificationDao.getNotifById(notifId);
        notificationDao.acknowledgeAlert(alert);
        return "redirect:/patientAlerts";
    }

    @RequestMapping(path = "/editPatient", method = RequestMethod.GET)
    public String queryPatient(HttpSession session, ModelMap modelMap){
        User user = (User) session.getAttribute("user");
        Patient patient = patientDao.getOnePatient(user.getId());
        modelMap.addAttribute("patient", patient);
        return "LoggedIn/User/usedByPatients/editPatient";
    }

    @RequestMapping(path = "/editPatient", method = RequestMethod.POST)
    public String updatePatient(@Valid @ModelAttribute Patient patient, HttpSession session, BindingResult result, RedirectAttributes flash){
        if (result.hasErrors()) {
            flash.addFlashAttribute("patient", patient);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "patient", result);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "LoggedIn/User/usedByPatients/editPatient";
        }
        User user = (User) session.getAttribute("user");
        patient.setUserId(user.getId());
        patientDao.updatePatient(patient);
        session.setAttribute("patient", patient);
        return "redirect:/private";
    }
}


