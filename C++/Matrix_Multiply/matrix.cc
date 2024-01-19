/* 	Sterling Johnson
    Z1944312
    CSCI-340-PE1

    I certify that this is my own work and where appropriate an extension
    of the starter code provided for the assignment.
*/

#include <istream>
#include <iostream>
#include <iomanip>
#include <vector>
#include <string>

#include "matrix.h"

using namespace std;


//constructor
matrix::matrix(unsigned int rows, unsigned int cols) : mat{}
    {
        mat = vector<vector<int> >(rows, vector<int>(cols, 0));
    }

 
    void matrix::resize(unsigned int rows, unsigned int cols)
    {
        mat.resize(rows);  // sets size for rows

        for (unsigned int row = 0; row != mat.size(); ++row)
        {
            mat[row].resize(cols);   // sets size for columns

        }
    }

    void matrix::load(istream& is)
    {
        unsigned int rowSize;
        unsigned int colSize;
        is >> rowSize; //read in the first int, for row size
        is >> colSize; //read in the second int, for column size

        resize(rowSize, colSize); //ensure matrix is the proper size before loading in the elements


        int d; //used to store incoming integer
        for (unsigned int row = 0; row < getRows(); ++row)
        {
            for (unsigned int col = 0; col <getCols(); ++col)
            {
                is >> d;
                at(row, col) = d; //places integer into row,col element
            }
        }
        
    }

    //output the matrix
    void matrix::print(int colWidth) const
    {
         //header
        cout << "Matrix Multiplication\n";
        string border(colWidth, '-'); //places top border
        cout << border << "\n";
        for (unsigned int row = 0; row < getRows(); ++row) //loop to print each row
        {
            cout << "|";
            for (unsigned int col = 0; col < getCols(); ++col) //loop to print each column
            {
                cout << at(row, col) << "|"; // outputs each elements
            }
            cout << "\n";

        }
        cout << border << "\n"; // places bottom border
    }


    ///need to set up an if satement to multiple as needed

    /// add the assert
    matrix matrix::operator*(const matrix& rhs) const
    {
        matrix temp; //holds matrix multiplication results
        temp.resize(getRows(), rhs.getCols()); //sets temp matrix size equal to current matrix size

        for (unsigned int i = 0; i < getRows(); ++i) //used to multiply row of first matrix
        {
            for (unsigned int j = 0; j < rhs.getCols(); ++j) //with column of second matrix
            {

                for (unsigned int k = 0; k < getCols(); ++k) // adds all of them for each value of k in the index
                {

                    temp.at(i, j) += at(i, k) * rhs.at(k, j);

                }
            }
        }
        return temp;
    }


    /// add the assert