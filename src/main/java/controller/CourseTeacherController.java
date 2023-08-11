package com.techelevator.controller;

import com.techelevator.model.Teacher.Teacher;
import com.techelevator.model.Teacher.JdbcTeacherDao;
import com.techelevator.model.Notification.JdbcNotificationDao;
import com.techelevator.model.Office.JdbcOfficeDao;
import com.techelevator.model.Office.Office;
import com.techelevator.model.TimeSlot.JdbcTimeSlotDao;
import com.techelevator.model.TimeSlot.TimeSlot;
import com.techelevator.model.User.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import javax.validation.Valid;
import java.util.List;

@Controller
public class CourseTeacherController {
    public CourseTeacherController() {
    }

    @Autowired
    private JdbcOfficeDao officeDao;
    @Autowired
    private JdbcTeacherDao TeacherDao;
    @Autowired
    private JdbcNotificationDao notificationDao;
    @Autowired
    private JdbcTimeSlotDao timeSlotDao;


    @RequestMapping(path = "/myOffice", method = RequestMethod.GET)
    public String showOneOfficeSearchPostForTeacher(HttpSession session, ModelMap modelMap) {
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        Long officeId = Teacher.getOfficeId();
        Office office = officeDao.getOfficeById(officeId);
        modelMap.put("office", office);
        session.setAttribute("office", office);
        return "LoggedIn/Offices/usedByTeachers/myOffice";
    }

    @RequestMapping(name = "/editOffice", method = RequestMethod.POST)
    public String updateOfficeInformation(@Valid @ModelAttribute("office") Office office, BindingResult result, RedirectAttributes flash, HttpSession session) {
        if (result.hasErrors()) {
            flash.addFlashAttribute("office", office);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "office", result);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "LoggedIn/Offices/usedByTeachers/editOffice";
        }
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        Office oldOffice = officeDao.getOfficeById(office.getOfficeId());
        officeDao.updateOffice(office);
        Office newOffice = officeDao.getOfficeById(office.getOfficeId());
        if (!(oldOffice.getAddress().equals(newOffice.getAddress()))) {
            List<TimeSlot> myAppointments = timeSlotDao.seeMyAgenda(Teacher.getTeacherId());
            for (TimeSlot appointment : myAppointments) {
                String content = notificationDao.generateForPatientMoved(appointment, Teacher, oldOffice, newOffice);
                notificationDao.createNotif(appointment.getPatientId(), Teacher.getTeacherId(), content, false);
            }
        }
        return "redirect:/myOffice";
    }

    @RequestMapping(path = "/editOffice", method = RequestMethod.GET)
    public String showOneOfficeFormForTeacherToUpdate(HttpSession session, ModelMap modelMap) {
        Office office = (Office) session.getAttribute("office");
        modelMap.addAttribute("office", office);
        return "LoggedIn/Offices/usedByTeachers/editOffice";
    }

    @RequestMapping(path = "/addNewOffice", method = RequestMethod.GET)
    public String queryForOfficeDetails(HttpSession session, ModelMap modelMap){
        if (!modelMap.containsAttribute("office")) {
            modelMap.put("office", new Office());
        }
        return "LoggedIn/Offices/usedByTeachers/addNewOffice";
    }

    @RequestMapping(path = "/addNewOffice", method = RequestMethod.POST)
    public String newOfficeSubmit(@Valid @ModelAttribute("office") Office office, HttpSession session, BindingResult result, RedirectAttributes flash) {
        if (result.hasErrors()) {
            flash.addFlashAttribute("office", office);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "office", office);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "redirect:/addNewOffice";
        }
        Office newOffice = officeDao.createNewOffice(office);
        User user = (User) session.getAttribute("user");
        Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
        TeacherDao.assignToOffice(Teacher.getTeacherId(), office.getOfficeId());
        return "redirect:/private";
    }
}
