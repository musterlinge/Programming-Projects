/* 	Sterling Johnson
    Z1944312
    CSCI-340-PE1

    I certify that this is my own work and where appropriate an extension
    of the starter code provided for the assignment.
*/

#include "twosearch.h"

#include <getopt.h>
#include <algorithm>
#include <iostream>
#include <iomanip>
#include <string>

using namespace std;

/**
* see:
* https://en.wikipedia.org/wiki/Usage_message
* https://www.ibm.com/docs/en/aix/7.2?topic=commands-usage-statements
*
* @param a0 The value of argv[0] (the name of the command) so that it
*   can be printed.
*
* @note This function will terminate the application via exit(1).
******************************************************************************/
static void usage(const char* a0)
{
    std::cerr << "Usage: " << a0 << " [-l rand_low] [-h rand_high] [-a a_size] [-b b_size] [-x a_seed] [-y b_seed] [-c print_cols] [-w col_width]" << std::endl;
    std::cerr << "    rand_low   = rand() low bound (default=1)" << std::endl;
    std::cerr << "    rand_high  = rand() high bound (default=1000)" << std::endl;
    std::cerr << "    a_size     = size of vector A (default=200)" << std::endl;
    std::cerr << "    b_size     = size of vector B (default=100)" << std::endl;
    std::cerr << "    a_seed     = random seed for vector A (default=1)" << std::endl;
    std::cerr << "    b_seed     = random seed for vector B (default=3)" << std::endl;
    std::cerr << "    print_cols = number of colums per line (default=16)" << std::endl;
    std::cerr << "    col_width  = printed column value width (default=4)" << std::endl;
    exit(1);
} // End of usage()

/**
* Parse the command-line args, create and sort vector A, create vector B,
* search vector A for those elements appearing in vector B using both
* a linear and binary search, and print the hit-rate (the percentage of
* items in B that have been located in A.)
*
* If an invalid command-line arg is encountered, print a Usage statement
* and terminte with an exit-status of 1.
*
* @return zero
******************************************************************************/
int main(int argc, char** argv)
{
    // Demonstrate the use of getopt() to override default config parameters 
    int rand_low = 1;
    int rand_high = 1000;
    int a_size = 200;
    int b_size = 100;
    int a_seed = 1;
    int b_seed = 3;
    int print_cols = 16;
    int col_width = 4;

 int opt; 
    // see: http://faculty.cs.niu.edu/~winans/CS340/2022-sp/#getopt
  while ((opt = getopt(argc, argv, "a:b:c:h:l:w:x:y:")) != -1)
    {
        switch (opt)
        {
        case 'a':
            // see https://en.cppreference.com/w/cpp/string/basic_string/stol
            a_size = std::stoi(optarg); // override the default for a_size
            break;

        case 'b':
            b_size = std::stoi(optarg); // override the default for b_size
            break;
        case 'c':
            print_cols = std::stoi(optarg); // override the default for print_cols
            break;
        case 'h':
            rand_high = std::stoi(optarg); // override the default for rand_high
            break;
        case 'l':
            rand_low = std::stoi(optarg); // override the default for rand_low
            break;
        case 'w':
            col_width = std::stoi(optarg); // override the default for col_width
            break;
        case 'x':
            a_seed = std::stoi(optarg); // override the default for a_seed
            break;
        case 'y':
            b_seed = std::stoi(optarg); // override the default for b_seed
            break;

        default:
            // got an arg that is not recognized...
            usage(argv[0]);     // pass the name of the program so it can print it
        }
    }

    // Make sure there are not any more arguments (after the optional ones)
    if (optind < argc)
        usage(argv[0]);

   //declaring vectors
    vector<int> A(a_size, 0);
    vector<int> B(b_size, 0);
    //storing random variables to vector
    init_vector(A, a_seed, rand_low, rand_high);
    init_vector(B, b_seed, rand_low, rand_high);
    //outputs vector A
    cout << "A vector:\n";
    print_vector(A, print_cols, col_width);
    //sorts and prints vector A
    sort_vector(A);
    cout << "A vector sorted:\n";
    print_vector(A, print_cols, col_width);
    //prints vector B
    cout << "B vector:\n";
    print_vector(B, print_cols, col_width);
    //searches for elements in B and compares to elements in A using Linear search and prints results
    cout << "\nLinear Search : Percent of Successful Searches = ";
    print_stat(search_vector(A, B, linear_search), b_size);
    //searches for elements in B and compares to elements in A using Binary search and prints results
    cout << "\nBinary Search : Percent of Successful Searches = ";
    print_stat(search_vector(A, B, binary_search), b_size);

    return 0;

} // End of main()

/* fills vector with random ints
@param vec A vector that needs random ints assigned to each element.
@param seed A int used to seed the srand function.
@param lo A int used to identify the low end of a rand call
@param hu A int used to identify the high end of a rand call
*/
void init_vector(std::vector<int>& vec, int seed, int lo, int hi)
{
    srand(seed);
    for (unsigned int i = 0; i < vec.size(); ++i)
    {

        vec[i] = (rand() % (hi - lo + 1) + lo);

    }
}

/*prints elements of a vector in table format
@param v A vector that needs to be printed
@param print_cols the number of columns that need to be printed for each row
@param col_width the width each column should be printed
*/
void print_vector(const std::vector<int>& v, int print_cols, int col_width)
{
    // creates the border length based on column width, number of rows and border lines
    string border((((col_width + 2) * print_cols)+2), '-'); 
    cout << border << "\n"; //prints top border

    unsigned int i = 0;
    while ( i < v.size()) // continues to print for necessary number of rows
    {
        cout << "| ";
            for (int k = 0; k < print_cols; ++k)//prints
            {
                if (i < v.size())
                {
                    cout << setw(col_width) << v[i] << " |";
                    i++; //increases i to keep track of which element was printed last
                 
                }
                //if no more elements in v to print, prints blank space
                else
                {
                    cout << setw(col_width) << " " << " |";
                }

            }
        cout << "\n"; //creates new line for next row

    }
    cout << border << "\n"; // prints bottom border
}

/* sorts vector in ascending order
@param v A vector that needs to be sorted.
*/
void sort_vector(std::vector<int>& v)
{
    sort(begin(v), end(v));
}

/* searches vector to determine how many matches there are between two vectors, takes in name of function as the final argument
@param v1 A vector used to compare the elements of v2 with
@param v2 The vector that used to find out how many matches it has with V1
@param p A pointer the address of the function that is being used for a search
@return the number of matches that were found between vector V2 and V1
@note If using the binary search algorithm, v1 needs to be sorted first
*/
int search_vector(const std::vector<int>& v1, const std::vector<int>& v2, bool (*p)(const std::vector<int>&, int))
{
    int numFinds = 0; // tracks number of items that matched from v2 with v1
    for (unsigned int i = 0; i < v2.size(); ++i)
    {
        //if item from v2 is found in v1, then numFinds is incremented
        if (p(v1, v2[i]))
        {
            numFinds++;
        }
    }
    return numFinds;
}

/* outputs percentage of items found found based on total number of possible elements
@param found the number of matches that were found
@param total the number of total elements in the vector that was used to compare
*/
void print_stat(int found, int total)
{
    cout << static_cast<float>(found) / static_cast<float> (total) * 100 << " %";
}

/* searches vector to determine if there is an element that matches x using Linear search
@param v vector used to compare to x
@param x int that needs to be searched in v
@return returns true if x was in v, else returns false

*/
bool linear_search(const std::vector<int>& v, int x)
{
    bool found = false; // used to determine if x was found in vector v
    if (std::find(v.begin(), v.end(), x) != v.end()) //if found
    {
        found = true;
    }
    else
    {
        found = false;
    }
    return found;

}

/* searches vector to determine if there is an element that matches x using Binary search
@param v vector used to compare to x
@param x int that needs to be searched in v
@return returns true if x was in v, else returns false
@note Uses the binary search algorithm, so v must be sorted
*/
bool binary_search(const std::vector<int>& v, int x)
{
    //returns bool based on if element is found
    return binary_search(v.begin(), v.end(), x);
}