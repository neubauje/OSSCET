package model;

import java.util.List;

public interface StudentDao {



    /**
     * Get all of the Students from the database.
     * @return a List of Student objects
     */
    public List<Student> getAllStudents();

}
