package model;

import org.hibernate.validator.constraints.NotBlank;
import org.springframework.format.annotation.DateTimeFormat;

import javax.validation.constraints.NotNull;
import java.time.LocalTime;

public class Course {

  private long CourseId;
  @NotBlank(message = "Course Name is required")
  private String CourseName;
  @NotBlank(message = "Course address is required")
  private String address;
  private String daysOpen;
  @NotNull(message = "Please enter the opening time")
  @DateTimeFormat(pattern="HH:mm")
  private LocalTime openingHours;
  @NotNull(message = "Please enter the closing time")
  @DateTimeFormat(pattern="HH:mm")
  private LocalTime closingHours;
  @NotBlank(message = "Phone number is required")
  private String phoneNumber;
  @NotNull(message = "Cost per hour is required. Enter 0 if pro bono.")
  private Double costPerHour;
  private int averageRating;

  public int getAverageRating() {
    return averageRating;
  }

  public void setAverageRating(int averageRating) {
    this.averageRating = averageRating;
  }

  public Course(long CourseId, String CourseName) {
    this.CourseId = CourseId;
    this.CourseName = CourseName;
  }
public Course(){

}

  public long getCourseId() {
    return CourseId;
  }

  public void setCourseId(long CourseId) {
    this.CourseId = CourseId;
  }


  public String getCourseName() {
    return CourseName;
  }

  public void setCourseName(String CourseName) {
    this.CourseName = CourseName;
  }


  public String getAddress() {
    return address;
  }

  public void setAddress(String address) {
    this.address = address;
  }


  public String getDaysOpen() {
    return daysOpen;
  }

  public void setDaysOpen(String daysOpen) {
    this.daysOpen = daysOpen;
  }


  public LocalTime getOpeningHours() {
    return openingHours;
  }

  public void setOpeningHours(LocalTime openingHours) {
    this.openingHours = openingHours;
  }


  public LocalTime getClosingHours() {
    return closingHours;
  }

  public void setClosingHours(LocalTime closingHours) {
    this.closingHours = closingHours;
  }


  public String getPhoneNumber() {
    return phoneNumber;
  }

  public void setPhoneNumber(String phoneNumber) {
    this.phoneNumber = phoneNumber;
  }


  public Double getCostPerHour() {
    return costPerHour;
  }

  public void setCostPerHour(Double costPerHour) {
    this.costPerHour = costPerHour;
  }

}
