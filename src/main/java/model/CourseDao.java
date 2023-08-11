package model;

import java.util.List;

public interface CourseDao {

    /**
     * Get an Course from the database that has the given id.
     * If the id is not found, return null.
     *
     * @param CourseName the Course id to get from the datastore
     * @return an Course
     */
    public Course getCourse(String CourseName);

    public Course getCourseById(Long id);
    public void updateCourse(Course updatedCourse);

    /**
     * Get all Courses from the datastore.
     *
     * @return all Courses as  objects in a List
     */
    public List<Course> getAllCourses();


}
