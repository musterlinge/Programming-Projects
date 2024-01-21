/* 	Sterling Johnson
	Z1944312
	CSCI-340-PE1

	I certify that this is my own work and where appropriate an extension
	of the starter code provided for the assignment.
*/


#include "htable.h"
#include "entry.h"
#include <list>
#include <vector>
#include <string>
#include <algorithm>
#include <iostream>
#include <iomanip>

#define N1 10  // num of decimal digits
#define N2 26  // num of upper-case letters

/*Locate hash table position
@param s a string key used to locate hash table postion
@return The index of the vector element where string key should be located
*/
int HT::hash(const string& s) {
	int n = (N2 * N1) * (s[0] - 'A') + N1 * (s[1] - 'A') + (s[2] - '0');

	return n % hsize;
}

/* Constructor
@param hs the size of the hashtable
*/
HT::HT(const unsigned& hs)
{
	hsize = hs;
	hTable = vector<list<Entry> >(hsize, std::list<Entry>());
}

//destructor
HT::~HT()
{
}


/* inserts a Entry into the hash table
@param e Entry that needs to be added
@note if the Entry key is already in table, a duplicate will not be added
*/
void HT::insert(const Entry& e)
{
	int position = hash(e.key);
	list<Entry>& l = hTable[position];
	/// if not found in the table already, then inserts into the table
	auto it = find_if(l.begin(), l.end(), [&](const Entry& d) {return e.key == d.key;});

	if (it == l.end())
	{
		hTable[position].push_front(e);
		std::cout << " entry =  " << position << "\n";
		pTable.push_back(&hTable[position].front());
	}
	else
	{
		std::cout << " not inserted - duplicate key!!!\n";
	}
}

/* Searches the hash table for the key represented by s
@param s the key that needs to be searched for
*/
void HT::search(const string& s)
{
	int position = hash(s);
	list<Entry>& l = hTable[position];
	auto it = find_if(l.begin(), l.end(), [&](const Entry& e) {return e.key == s;});
	//if s not found in s then prints an error message
	if (it == l.end())
	{
		std::cout << s << "not in the table!!\n";
	}
	//if s is found, then prints details of that entry
	else
	{
		Entry foundEntry = *it;
		std::cout << foundEntry.key << " ==> number:" << setw(5) << foundEntry.num << " - item : " << foundEntry.desc << "\n";
	}
}

/* Prints the hash table
*/
void HT::hTable_print()
{
	std::cout << "\n";
	for (unsigned int i = 0; i < hsize && i < hTable.size(); ++i)
	{
		list<Entry>& l = hTable[i];
		for (auto it = l.begin(); it != l.end(); ++it)
		{
			Entry Entry = *it;
			if (Entry.key != "")
			{
				std::cout << setw(4) << left << i << ":" << it->key << "    - "
					<< setw(7) << left << it->num << " -  " << it->desc << "\n";
			}
		}
	}
}

/* Prints the pointer table
*/
void HT::pTable_print()
{
	std::cout << "\n";
	sort(pTable.begin(), pTable.end(), [](Entry* p, Entry* q) {return p->key < q->key;});
	for (auto entry : pTable)
	{
		std::cout << "   " << entry->key << "  - " << setw(5) << right << entry->num << "  -  " << entry->desc << "\n";
	}
}
