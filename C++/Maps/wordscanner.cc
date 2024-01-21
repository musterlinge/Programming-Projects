/* 	Sterling Johnson
	Z1944312
	CSCI-340-PE1

	I certify that this is my own work and where appropriate an extension
	of the starter code provided for the assignment.
*/


#include <map>
#include <iostream>
#include <string>
#include <utility>
#include <cctype>
#include <iomanip>
#include <algorithm>

using namespace std;

void get_words(map<string, int> &m);
void print_words(const map<string, int>& m);
void clean_entry(const string& n, string& m);

/* reads in a file and returns the number of words and the occurrences of those words
@returns 0 if successful
*/
int main()
{

	map<string, int> words;
	get_words(words);
	print_words(words);

	return 0;
}


/*Gets the input of words and adds them to the map m
@param m the map where the words and the number of occurences should be added
*/
void get_words(map<string, int> &m)
{
	string line;
	while (cin >> line)
	{
		unsigned int i = 0;
		while (i < line.size())
		{
			string temp;
			//loop performs until a space is found
			while (line[i] != ' ' && i < line.size())
			{
				//adds letter to temp word
				temp += line[i];
				++i;
			}
			//increments past the space
			++i;
			string word;
			clean_entry(temp, word);
			//if length is more than zero after cleaning entry, adds word to map
			if (word.length() != 0)
			{
				m[word]++;
			}
		}
	}
}

/*Prints a list of the names of the word in m followed by their occurrences
@param m the map that should be printed
*/
void print_words(const map<string, int>& m)
{
	int NO_ITEMS = 4; //no of items printed in a row
	int ITEM_WORD_WIDTH = 14; //width of line for each word
	int	ITEM_COUNT_WIDTH = 3; //width of line for the count of each word
	int countWords = 1; //counts how many words have been printed on a line so far
	int totalInput = 0; //counts number of occurrences for all words in m

	//outputs m
	for_each(m.cbegin(), m.cend(), [&](const auto& m) {cout << left << setw(ITEM_WORD_WIDTH)
		<< m.first << ":"  << setw(ITEM_COUNT_WIDTH) << m.second;
	//if reached the number of items in a row set by NO_ITEMS, resets the counter and prints a new line
	if (countWords == NO_ITEMS)
		{
		cout << "\n";
		countWords = 0;
		}
		++countWords;
		totalInput += m.second;//adds all occurrences of current word to the totalInput
		});
	cout << "\nnumber of words in input stream   :" << totalInput;
	cout << "\nnumber of words in output stream  :" << m.size() << "\n";
}

/*Removes punctuation and any letters after the punctuation of a word
@param n the word that needs to be checked/ remove punctuation
@param m returns n without the punctuation or letters following the punctuation
*/
void clean_entry(const string& n, string& m)
{
	//sets alphaIt to the first char that is an alphanumeric char
	auto alphaIt = find_if(n.begin(), n.end(), [](const auto& a) {return isalnum(a);});
	//sets nonAlphaIt to the first char that is a non-alphanumeric char
	auto nonAlphaIt = find_if(n.begin(), n.end(), [](const auto& a) {return !isalnum(a);});
	//sets temp  to 
	string temp(alphaIt, nonAlphaIt);
	//changes all letters in word to lowercase
	for_each(temp.begin(), temp.end(), [&] (auto& letter) {letter = tolower(letter);});
	m = temp;


}
