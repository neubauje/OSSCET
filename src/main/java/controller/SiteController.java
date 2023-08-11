package com.techelevator.controller;

import authentication.AuthProvider;
import authentication.UnauthorizedException;
import model.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;

import javax.servlet.http.HttpSession;
import java.util.ArrayList;
import java.util.List;

/**
     * SiteController
     */
    @Controller
    public class SiteController {
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

        @RequestMapping(path = "/private", method = RequestMethod.GET)
        public String privatePage(ModelMap model, HttpSession session) throws UnauthorizedException {
            if (auth.userHasRole(new String[] { "Teacher", "Patient" })) {
                User user = (User) session.getAttribute("user");
                model.addAttribute("user", user);
                if (user.getRole().equals("Teacher")){
                    Teacher Teacher = TeacherDao.getOneTeacherByUserId(user.getId());
                    model.addAttribute("Teacher", Teacher);
                    Office office = officeDao.getOfficeById(Teacher.getOfficeId());
                    model.addAttribute("office", office);
                }
                else {
                    Patient patient = patientDao.getOnePatient(user.getId());
                    model.addAttribute("patient", patient);
                }
                Boolean alert = notificationDao.hasUnreadNotifs(user.getId());
                model.addAttribute("alert", alert);
                return "LoggedIn/User/private";
            } else {
                throw new UnauthorizedException();
            }
        }

        @RequestMapping(path = "/about", method = RequestMethod.GET)
        public String aboutPage() throws UnauthorizedException {
            return "about";
        }

    }


