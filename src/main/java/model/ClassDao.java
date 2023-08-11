package model;

import java.time.LocalDate;
import java.util.List;

public interface ClassDao {
    public List<Class> findFreeSlots(LocalDate date, Long TeacherId);
    public List<Class> findFreeSlots(Long TeacherId);
    public List<Class> seeMyAgenda(Long TeacherId);

}
