#ifndef H_MATRIX_MULTIPLY
#define H_MATRIX_MULTIPLY

#include <istream>
#include <vector>

// NOTE: Do not pollute every #includer's namespace by putting 'using' statements in header files!

class matrix
{
public:
    matrix(unsigned int rows=0, unsigned int cols=0);
    void resize(unsigned int rows, unsigned int cols);
    void load(std::istream &is);
    void print(int colWidth) const;

    // Implement both a const and non-const version of at() so can use in 
    // different contexts such as an rvalue or lvalue.
    const int & at(unsigned int row, unsigned int col) const
    {
        return mat[row][col];       // note that mat[row] returns a reference to the col vector
    }
    int & at(unsigned int row, unsigned int col)
    {
        return mat[row][col];       // note that mat[row] returns a reference to the col vector
    }

    matrix operator*(const matrix&) const;  // see CSCI 241 rational.cpp example

    // the number of roiws is the number of column vectors! 
    unsigned int getRows() const { return mat.size(); }

    // Note that if have 0 rows then we have no col vectors to ask about their size!
    unsigned int getCols() const { return (getRows()==0? 0 : mat[0].size()); }

private:

    // can't use vector<vector<int> > A(nrows, vector<int>(ncols)) notation because might 
    // not know the dimension when constructed.
    std::vector<std::vector<int>> mat;      // rows is the outer vector. be careful with the >>
};

#endif

#include "hex.h"
#include "memory.h"

#ifndef H_HEX
#define H_HEX

class hex
{
public :
static std :: string to_hex8 ( uint8_t i );
static std :: string to_hex32 ( uint32_t i );
static std :: string to_hex0x32 ( uint32_t i );
};
#endif

#ifndef H_MEMORY
#define H_MEMORY


class memory : public hex
{
public :
memory ( uint32_t s );
 ~ memory ();

bool check_illegal ( uint32_t addr ) const ;
uint32_t get_size () const ;
uint8_t get8 ( uint32_t addr ) const ;
uint16_t get16 ( uint32_t addr ) const ;
uint32_t get32 ( uint32_t addr ) const ;

int32_t get8_sx ( uint32_t addr ) const ;
int32_t get16_sx ( uint32_t addr ) const ;
int32_t get32_sx ( uint32_t addr ) const ;

void set8 ( uint32_t addr , uint8_t val );
void set16 ( uint32_t addr , uint16_t val );
void set32 ( uint32_t addr , uint32_t val );

void dump () const ;

bool load_file ( const std :: string & fname );

private :
std :: vector < uint8_t > mem ;
};
#endif



std::string hex::to_hex8(uint8_t i)
{
std::ostringstream os;
os << std::hex << std::setfill(’0’) << std::setw(2) << static_cast<uint16_t>(i);
return os.str();
}

static std :: string to_hex32 ( uint32_t i )
{
std::ostringstream os;
os << std::hex << std::setfill(’0’) << std::setw(8) << static_cast<uint32_t>(i);
return os.str();
}

static std :: string to_hex0x32 ( uint32_t i );
{
return std::string("0x")+to_hex32(i);
}