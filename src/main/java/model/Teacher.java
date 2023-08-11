package model;

import org.hibernate.validator.constraints.NotBlank;

public class Teacher {
    private long TeacherId;
    private long CourseId;

    @NotBlank(message = "First name is required")
    private String firstName;
    @NotBlank(message = "Last name is required")
    private String lastName;
    @NotBlank(message = "Please provide some information about yourself. This will appear on your Course summary.")
    private String specialty;
    private long userId;
//    private boolean CourseSelect;

//    public boolean isCourseSelect() {
//        return CourseSelect;
//    }
//
//    public void setCourseSelect(boolean CourseSelect) {
//        this.CourseSelect = CourseSelect;
//    }

    public long getUserId() {
        return userId;
    }

    public void setUserId(long userId) {
        this.userId = userId;
    }

    public long getTeacherId() {
        return TeacherId;
    }

    public void setTeacherId(long TeacherId) {
        this.TeacherId = TeacherId;
    }

    public long getCourseId() {
        return CourseId;
    }

    public void setCourseId(long CourseId) {
        this.CourseId = CourseId;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getSpecialty() {
        return specialty;
    }

    public void setSpecialty(String specialty) {
        this.specialty = specialty;
    }

}
