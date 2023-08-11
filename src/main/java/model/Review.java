package model;


import javax.validation.constraints.Max;
import javax.validation.constraints.Min;
import java.time.LocalDate;

public class Review {

  private long reviewId;
  private long userId;
  private String message;

  @Max(value = 10, message = "maximum rating cannot exceed 10")
  @Min(value = 0, message = "minimum rating cannot be lower than 0")
  private long rating;


  private LocalDate dateSubmitted;
  private long CourseId;
  private long TeacherId;
  private String TeacherResponse;

  public String getTeacherResponse() {
    return TeacherResponse;
  }

  public void setTeacherResponse(String TeacherResponse) {
    this.TeacherResponse = TeacherResponse;
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

  public long getReviewId() {
    return reviewId;
  }

  public void setReviewId(long reviewId) {
    this.reviewId = reviewId;
  }


  public long getUserId() {
    return userId;
  }

  public void setUserId(long userId) {
    this.userId = userId;
  }


  public String getMessage() {
    return message;
  }

  public void setMessage(String message) {
    this.message = message;
  }


  public long getRating() {
    return rating;
  }

  public void setRating(long rating) {
    this.rating = rating;
  }


  public LocalDate getDateSubmitted() {
    return dateSubmitted;
  }

  public void setDateSubmitted(LocalDate dateSubmitted) {
    this.dateSubmitted = dateSubmitted;
  }

}
