package model;


import java.time.LocalDateTime;

public class Notification {

  private long notifId;
  private long TeacherId;
  private long StudentId;
  private String contents;
  private LocalDateTime dateTime;
  private Boolean acknowledged;
  private Boolean intendedForTeacher;

  public Boolean getIntendedForTeacher() {
    return intendedForTeacher;
  }

  public void setIntendedForTeacher(Boolean intendedForTeacher) {
    this.intendedForTeacher = intendedForTeacher;
  }

  public long getTeacherId() {
    return TeacherId;
  }

  public void setTeacherId(long TeacherId) {
    this.TeacherId = TeacherId;
  }

  public long getStudentId() {
    return StudentId;
  }

  public void setStudentId(long StudentId) {
    this.StudentId = StudentId;
  }

  public long getNotifId() {
    return notifId;
  }

  public void setNotifId(long notifId) {
    this.notifId = notifId;
  }

  public String getContents() {
    return contents;
  }

  public void setContents(String contents) {
    this.contents = contents;
  }

  public LocalDateTime getDateTime() {
    return dateTime;
  }

  public void setDateTime(LocalDateTime dateTime) {
    this.dateTime = dateTime;
  }

  public Boolean getAcknowledged() {
    return acknowledged;
  }

  public void setAcknowledged(Boolean acknowledged) {
    this.acknowledged = acknowledged;
  }
}
