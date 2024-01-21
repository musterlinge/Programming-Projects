//***************************************************************************
//
//  Sterling Johnson
//  Z1944312
//  CSCI463
//
//  I certify that this is my own work and where appropriate an extension 
//  of the starter code provided for the assignment.
//
//***************************************************************************

#include "josephus.h"

#include <list>
#include <iostream>
#include <sstream>
#include <string>
#include <algorithm>
#include <iterator>
#include <getopt.h>

using namespace std;

void print_underlined_string(const string& message);
int main(int argc, char** argv);
void print_list(const list<string>& collection, const unsigned int& eliminations, int num_cols);


/**
* Print a 'Usage' message and exit(1).
*
* @param a0 The name of the command to include in the usage message.
*****************************************************************************/
static void usage(const char* a0)
{
    std::cerr << "Usage: " << a0 << " [-n number of people] [-m modulus] [-p print frequency] [-c print columns]" << std::endl;
    exit(1);
}


/**
* Create a std::list of prople with generated ID/names and reduce the
* list as per the Josephus problem algorithm.
*****************************************************************************/
int main(int argc, char** argv)
{
    unsigned int num_people = 41;       // The number of people to start with
    unsigned int modulus = 3;           // The count used to determine the elimination
    unsigned int print_frequency = 13;  // How often to print the state of the system
    unsigned int num_cols = 12;         // Number of colums to print per line

    int opt;
    while ((opt = getopt(argc, argv, "n:m:p:c:")) != -1)
    {
        switch (opt)
        {
        case 'n':
            std::istringstream(optarg) >> num_people;
            break;
        case 'm':
            std::istringstream(optarg) >> modulus;
            break;
        case 'p':
            std::istringstream(optarg) >> print_frequency;
            break;
        case 'c':
            std::istringstream(optarg) >> num_cols;
            break;
        default:
            usage(argv[0]);
        }
    }

    if (optind < argc)
        usage(argv[0]); // If we get here, there was extra junk on command line
     


    list<string> contestants;
    unsigned int numOfElims = 0;
    generate_n(back_inserter(contestants), num_people, SEQ(num_people));
    print_list(contestants, numOfElims, num_cols);
    list<std::string>::iterator it = contestants.begin();
    //completes until one one remaining
    while (contestants.size() > 1)
    {
        //counts number of 
        for (unsigned int i = 0; i < modulus; ++i)
        {
            ++it;
            //if reached the end of the list, circles back to the front
            if (it == contestants.end())
            {
                it = contestants.begin();
            }
        }
        //replaces it with new final element
        it = contestants.erase(it);
        //ensures element is not pointing at end iterator
        if (it == contestants.end())
        {
            it = contestants.begin();
        }
        //increases number of eleminations
        ++numOfElims;
        if ((numOfElims % print_frequency) == 0)
        {
            cout << "\n";
            print_list(contestants, numOfElims, num_cols);
        }
    }

    cout << "\nEliminations Completed\n";
    print_list(contestants, numOfElims, num_cols);

    return 0;
}

/*Prints a list of the current remaining individuals
@param collection the list that needs to be printed
@param eliminations how many individuals need to be printed
@param num_cols integer of how many columns should be printed
*/
void print_list(const list<string> &collection, const unsigned int& eliminations, int num_cols)
{
    string header;
    if (eliminations == 0)
    {
        header = "Initial group of people";
    }
    else
    {
        header = "After eliminating " + to_string(eliminations);
        header += " people";

    }
    cout << header;
    print_underlined_string(header);
     
   
    for (auto it = collection.begin(); it != collection.end(); ++it)
    {   
        for (int i = 0; i < num_cols && it != collection.end(); ++i)
        {
            cout << *it;
            //checks if final element, if not then prints a comma
            auto itTemp = it;
            ++itTemp;
           if (itTemp != collection.end() && i != (num_cols - 1))
            {
              cout <<  ", ";
            }
            ++it;
        }
        cout << "\n";
        --it;
    }


}

/*Prints a list of the current remaining individuals
@param collection the list that needs to be printed
*/
void print_underlined_string(const string& message)
{
    string line(message.size(), '-');
    cout << "\n" << line << "\n\n";

}
