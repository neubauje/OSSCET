package model;

import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;
import java.time.LocalTime;

public class Class {
    private Long ClassId;

    @DateTimeFormat(pattern ="yyyy-MM-dd")
    private LocalDate date;
    private LocalTime startTime;
    private LocalTime endTime;
    private boolean assigned;
    private String description;
    private Long TeacherId;
    private Long StudentId;

    public Long getTeacherId() {
        return TeacherId;
    }

    public void setTeacherId(Long TeacherId) {
        this.TeacherId = TeacherId;
    }

    public Long getStudentId() {
        return StudentId;
    }

    public void setStudentId(Long StudentId) {
        this.StudentId = StudentId;
    }

    public Long getClassId() {
        return ClassId;
    }

    public void setClassId(Long ClassId) {
        this.ClassId = ClassId;
    }

    public LocalDate getDate() {
        return date;
    }

    public void setDate(LocalDate date) {
        this.date = date;
    }

    public LocalTime getStartTime() {
        return startTime;
    }

    public void setStartTime(LocalTime startTime) {
        this.startTime = startTime;
    }

    public LocalTime getEndTime() {
        return endTime;
    }

    public void setEndTime(LocalTime endTime) {
        this.endTime = endTime;
    }

    public boolean isAssigned() {
        return assigned;
    }

    public void setAssigned(boolean assigned) {
        this.assigned = assigned;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
}
