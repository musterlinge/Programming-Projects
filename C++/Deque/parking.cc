#include <string>
#include <deque>
#include <iostream>
#include "parking.h"
#include <stack>

using namespace std;

void get_input_vals(const std::string& line, char& xact_type, std::string& license);

//increases the number of times the car has been moved by one
void car::move()
{
	++num_moves;
}

/// @return the number of times that the car has been moved.
int car::get_num_moves() const
{
	//cout << "\nhere is number of moves " << num_moves << "\n";
	return num_moves;
}

/// @return A reference to the license for this car.
const string& car::get_license() const
{
	return license;
}

//adds car to the garage, if garage not full
/// @param license The license of the car that has arrived.                                                           
void garage::arrival(const string& license)
{

	car newArrival((parking_lot.size() + 1), license);
	cout << newArrival << " has arrived.\n";
	if ((parking_lot.size() + 1) == parking_lot_limit)
	{
		cout << "\tBut the garage is full!\n";
	}
	else
	{
		parking_lot.push_back(newArrival);
	}
}

//removes car from the garage, if license is in garage
/// @param license The license of the car that has departed.                                                          
void garage::departure(const string & license)
{
	bool found = false;
	unsigned int pos = 0;
	for (unsigned int i = 0; i < parking_lot.size() && !found; ++i)
	{
		if (parking_lot[i].get_license() == license)
		{
			found = true;
			pos = i;
		}
	}
	//if finds car in garage, removes car
	if (found)
	{
		//increase one to the counter for moving car
		parking_lot[pos].move();
		cout << parking_lot[pos] << " has departed,\n\tcar was moved " << parking_lot[pos].get_num_moves() << " time";
		if (parking_lot[pos].get_num_moves() > 1)
		{
			cout << "s";
		}
		cout << " in the garage\n";

		//holds cars that are moved out
		stack<car> t;
		//moves cars that to stack if needed
		unsigned int i = 0;
		while( i < pos && i < parking_lot.size())
		{
			//moves car
			parking_lot.front().move();
			//adds car to stack
			t.push(parking_lot.front());
			//removes the car from the parking lot
			parking_lot.pop_front();
			++i;
		}
		//removes car that is departing from the parking_loy
		parking_lot.pop_front();

		//readds car back to parking_lot
		while (!t.empty())
		{
			parking_lot.push_front(t.top());
			t.pop();
		}
	}
	//if unable to find car in the garage, prints an error message
	else
	{
		cout << "No car with license plate " << license << " is in the garage\n";
	}
}


int main()
{

	string input;
	char xact_type;
	string license;
	garage holding;

	while (getline(cin, input))
	{
		//if only whitespace captured with input, does not process loop
		if (!input.empty())
		{
			get_input_vals(input, xact_type, license);

			//if xact_type 'A' then initiates arrival
			if (xact_type == 'A')
			{
				holding.arrival(license);
			}
			//if xact_type 'D' then initiates departure
			else if (xact_type == 'D')
			{
				holding.departure(license);
			}
			//if not an A for arrival or D for departure, prints an error message
			else
			{
				cout << "'" << xact_type << "': invalid action!\n";
			}
			cout << "\n";
		}
	}

	return 0;
}

//helper function used to locate and return the action type and license number
//@param line a string that has the action type and license delimited with a ':'
//@param xact_type a char that is used to return the action type from line(i.e. D for departure or A for arrival)
//@param license a string that is used to return the license number from line
void get_input_vals(const std::string& line, char& xact_type, std::string& license)
{
	//if string empty, ouputs error message
	if (line.empty())
	{
		return;
	}
	
	//holds temporary xact_type & temporary license
	string tempType;
	string tempLic;

	unsigned int i = 0;
		//get xact_type
		while (line[i] != ':' && i <line.size())
		{
			tempType += line[i];
			++i;
			xact_type = line.front();
		}
		++i;
		//get license
		while (line[i] != ':' && i < line.size())
		{
			tempLic += line[i];
			++i;
		}
		license = tempLic;

}