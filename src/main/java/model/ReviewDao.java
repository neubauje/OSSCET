package model;

import java.util.List;

public interface ReviewDao {

        public List<Review> getAllReviews();

      public void save(Long userId, Long CourseId, int rating, String message);

        public List<Review> respond(Long CourseId);

        public void respondToReview(Review reviewUpdate);

        public Review getReview(long reviewId);

//  public void save(long reviewId, String username, String message, long rating, LocalDate dateSubmitted);
}

