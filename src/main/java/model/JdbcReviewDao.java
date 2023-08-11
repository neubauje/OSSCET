package model;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;
import java.util.ArrayList;
import java.util.List;

@Component
public class JdbcReviewDao implements ReviewDao {

    private JdbcTemplate jdbcTemplate;

    @Autowired
    public JdbcReviewDao(DataSource dataSource){
        this.jdbcTemplate = new JdbcTemplate(dataSource);
    }

    @Override
    public List<Review> getAllReviews() {
        List<Review> allReviews = new ArrayList<>();
        String sqlSelectAllReviews = "Select * from review";
        SqlRowSet medReview = jdbcTemplate.queryForRowSet(sqlSelectAllReviews);
        while (medReview.next()) {
            Review review = new Review();
            review.setReviewId(medReview.getLong("review_id"));
            review.setUserId(medReview.getLong("user_id"));
            review.setMessage(medReview.getString("message"));
            review.setRating(medReview.getInt("rating"));
            review.setDateSubmitted(medReview.getDate("date_submitted").toLocalDate());
            review.setTeacherResponse(medReview.getString("Teacher_response"));
            review.setTeacherId(medReview.getLong("Teacher_id"));
            allReviews.add(review);

        }
        return allReviews;
    }

    @Override
    public void save(Long userId, Long CourseId, int rating, String message) {
        String sqlInsertReview = "Insert into review (user_id, Course_id, rating, message, date_submitted) " +
                "values (?, ?, ?, ?, current_date)";
        jdbcTemplate.update(sqlInsertReview, userId, CourseId, rating, message);
    }


    private Long getNextId() {
        String sqlSelectNextId = "SELECT NEXTVAL('seq_review_id')";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sqlSelectNextId);
        Long id = null;
        if (results.next()) {
            id = results.getLong(1);
        } else {
            throw new RuntimeException("Review must be saved");
        }
        return id;
    }


    @Override
    public List<Review> respond(Long CourseId) {
        List<Review> reviews = new ArrayList<>();
        String sql = "select review_id from Course join review on Course.Course_id = review.Course_id " +
                "where Course.Course_id = ?;";
        SqlRowSet medResponds = jdbcTemplate.queryForRowSet(sql, CourseId);
        while (medResponds.next()){
            reviews.add(mapRowToReviews(medResponds));
        }
        return reviews;

    }
    public Review getReview(long reviewId){
        String sql = "select * from review where review_id = ?;";
        SqlRowSet getReviews = jdbcTemplate.queryForRowSet(sql, reviewId);
        Review review = null;
        if(getReviews.next()){
            review = mapRowToReviews(getReviews);
        }
        return review;
    }

    public void respondToReview(Review reviewUpdate){
      String sql = "Update review SET Teacher_response = ?, Teacher_id = ? where review_id = ?";
      jdbcTemplate.update(sql, reviewUpdate.getTeacherResponse(), reviewUpdate.getTeacherId(), reviewUpdate.getReviewId());

    }


    private Review mapRowToReviews(SqlRowSet medResponds) {
        Review review = new Review();
        review.setReviewId(medResponds.getLong("review_id"));
        review.setUserId(medResponds.getLong("user_id"));
        review.setMessage(medResponds.getString("message"));
        review.setRating(medResponds.getLong("rating"));
        review.setDateSubmitted(medResponds.getDate("date_submitted").toLocalDate());
        review.setCourseId(medResponds.getLong("Course_id"));
        review.setTeacherId(medResponds.getLong("Teacher_id"));
        review.setTeacherResponse(medResponds.getString("Teacher_response"));

        return review;
    }

    public List<Review> getReviewsByCourseId(Long CourseId){
        List<Review> ourFeedback = new ArrayList<>();
        String sql = "SELECT * from review where Course_id = ? order by date_submitted desc;";
        SqlRowSet results = jdbcTemplate.queryForRowSet(sql, CourseId);
        while (results.next()){
            ourFeedback.add(mapRowToReviews(results));
        }
        return ourFeedback;
    }

    public Course getAverageRating(Course Course){
        List<Review> reviews = getReviewsByCourseId(Course.getCourseId());
        int average = 0;
        if (reviews.size() > 0) {
            for (int i = 0; i < reviews.size(); i++) {
                average = (int) (average + reviews.get(i).getRating());
            }
            average = average / reviews.size();
        }
        Course.setAverageRating(average);
        return Course;
    }

}
