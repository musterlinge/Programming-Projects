#ifndef H_PARKING
#define H_PARKING

#include <string>
#include <deque>

class car
{
public:
    car(int id, const std::string& license) : id(id), license(license) {}


    /// Call this to increment the number of times the car has been moved.
    void move();

    /// @return the number of times that the car has been moved.
    int get_num_moves() const;

    /// @return A reference to the license for this car.
    const std::string& get_license() const;

    /**
    * Overload the << so this can print itself as:
    *    Car X with license plate "Y"
    * @param lhs ostream that will output
    ******************************************************************/
    friend std::ostream& operator<<(std::ostream& lhs, const car& rhs)
    {
        lhs << "Car " << rhs.id << " with license plate \"" << rhs.get_license() << "\"";
        return lhs;
    }

private:
    int id;                 ///< The ID number for this car (assigned by the garage)
    std::string license;    ///< license plate of this car.
    int num_moves = { 0 };    ///< how many times the car was moved within the garage.
};





class garage
{
public:
    garage(size_t limit = 10) : parking_lot_limit(limit) {}

    /// @param license The license of the car that has arrived.                                                           
    void arrival(const std::string& license);

    /// @param license The license of the car that has departed.                                                          
    void departure(const std::string& license);

private:
    int next_car_id = { 1 };
    std::deque<car> parking_lot;
    size_t parking_lot_limit;
};


#endif