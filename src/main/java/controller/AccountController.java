package com.techelevator.controller;

import com.techelevator.authentication.AuthProvider;
import com.techelevator.model.Teacher.Teacher;
import com.techelevator.model.Teacher.JdbcTeacherDao;
import com.techelevator.model.Office.JdbcOfficeDao;
import com.techelevator.model.Office.Office;
import com.techelevator.model.Patient.JdbcPatientDao;
import com.techelevator.model.Patient.Patient;
import com.techelevator.model.User.JdbcUserDao;
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
 * AccountController
 */
@Controller
public class AccountController {
    @Autowired
    private AuthProvider auth;
    @Autowired
    private JdbcPatientDao patientDao;
    @Autowired
    private JdbcTeacherDao TeacherDao;
    @Autowired
    private JdbcOfficeDao officeDao;
    @Autowired
    private JdbcUserDao userDao;

    @RequestMapping(method = RequestMethod.GET, path = {"/", "/index"})
    public String index(ModelMap modelHolder) {
        modelHolder.put("user", auth.getCurrentUser());
        return "index";
    }

    @RequestMapping(path = "/login", method = RequestMethod.GET)
    public String loginLoad(ModelMap modelHolder) {
        return "login";
    }


    @RequestMapping(path = "/login", method = RequestMethod.POST)
    public String loginSubmit(@RequestParam String username, @RequestParam String password, RedirectAttributes flash, HttpSession session, ModelMap modelMap) {
        if (auth.signIn(username, password)) {
            User user = userDao.getUserByUsername(username);
            session.setAttribute("user", user);
            modelMap.addAttribute("user", user);
            return "redirect:/private";
        } else {
            flash.addFlashAttribute("message", "Login Invalid");
            return "redirect:/login";
        }
    }

    @RequestMapping(path = "/logoff", method = RequestMethod.POST)
    public String logOff() {
        auth.logOff();
        return "redirect:/";
    }

    @RequestMapping(path = "/register", method = RequestMethod.GET)
    public String registerLoad(ModelMap modelHolder) {
        if (!modelHolder.containsAttribute("user")) {
            modelHolder.put("user", new User());
        }
        return "register";
    }

    @RequestMapping(path = "/TeacherRegister", method = RequestMethod.GET)
    public String TeacherRegisterLoad(ModelMap modelHolder) {
        if (!modelHolder.containsAttribute("Teacher")) {
            modelHolder.put("Teacher", new Teacher());
        }
        List<Office> officeList = officeDao.getAllOffices();
        modelHolder.addAttribute("offices", officeList);
        return "LoggedIn/User/usedByTeachers/TeacherRegister";
    }

    @RequestMapping(path = "/register", method = RequestMethod.POST)
    public String registerSubmit(@Valid @ModelAttribute("user") User user, BindingResult result, RedirectAttributes flash, HttpSession session) {
        if (result.hasErrors()) {
            flash.addFlashAttribute("user", user);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "user", result);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "redirect:/register";
        }
        User newUser = auth.register(user.getUsername(), user.getPassword(), user.getRole());
        session.setAttribute("user", newUser);
        if (newUser.getRole().equals("Teacher")) {
            return "redirect:TeacherRegister";
        } else {
            return "redirect:patientRegister";
        }
    }

    @RequestMapping(path = "/TeacherRegister", method = RequestMethod.POST)
    public String TeacherRegisterSubmit(@Valid @ModelAttribute("Teacher") Teacher Teacher, HttpSession session, BindingResult result, RedirectAttributes flash) {
        if (result.hasErrors()) {
            flash.addFlashAttribute("Teacher", Teacher);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "Teacher", result);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "redirect:/TeacherRegister";
        }
        User user = (User) session.getAttribute("user");
        TeacherDao.saveTeacher(user.getId(), Teacher.getOfficeId(), Teacher.getFirstName(), Teacher.getLastName(), Teacher.getSpecialty());
            return "redirect:/private";
    }

    @RequestMapping(path = "/patientRegister", method = RequestMethod.GET)
    public String patientRegisterLoad(ModelMap modelHolder) {
        if (!modelHolder.containsAttribute("patient")) {
            modelHolder.put("patient", new Patient());
        }
        return "LoggedIn/User/usedByPatients/patientRegister";
    }

    @RequestMapping(path = "/patientRegister", method = RequestMethod.POST)
    public String patientRegisterSubmit(@Valid @ModelAttribute("patient") Patient patient, HttpSession session, BindingResult result, RedirectAttributes flash) {
        if (result.hasErrors()) {
            flash.addFlashAttribute("patient", patient);
            flash.addFlashAttribute(BindingResult.MODEL_KEY_PREFIX + "patient", result);
            flash.addFlashAttribute("message", "Please fix the following errors:");
            return "redirect:/patientRegister";
        }
        User user = (User) session.getAttribute("user");
        patientDao.savePatient(user.getId(), patient.getFirstName(), patient.getLastName(), patient.getDateOfBirth(), patient.getPhoneNumber(), patient.getEmail(), patient.getEmergencyContact(), patient.getEmergencyName(), patient.getInsurance());
        return "LoggedIn/User/private";
    }

}