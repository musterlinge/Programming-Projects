/* 	Sterling Johnson
    Z1944312
    CSCI-340-PE1

    I certify that this is my own work and where appropriate an extension
    of the starter code provided for the assignment.
*/



#include "graph.h"
#include <fstream>
#include <string>
#include <cctype>	
#include <iostream>
#include <map>

using namespace std;


map<int, bool> elementVisited;
vector< pair<int, int> >edges; //stores edges for traversal;

/*Traverses the graph using the Depth First Search/ Algorithm 
@param v the vertex to begin the traversal on
*/
void Graph::Depthfirst(int v) 
{

	elementVisited[v] = true;
	cout << labels[v] << " ";
	
	for(auto i = adj_list[v].begin(); i != adj_list[v].end(); ++i)
	{
		if(!elementVisited[*i])
		{
			edges.push_back(make_pair(v, *i));
			Depthfirst(*i);
		}
	}
	
}

/* Constructor
@param filename the name of the file that needs to be opened 
@note the first line of the file should include the number of vertexs, the first column/header should be the name of the vertex
*/
Graph::Graph(const char* filename)
{
	ifstream infile;
	infile.open(filename);
	
	int graphSize; //holds size of graph from input
	string input; // holds each line of input from edges

	
	infile >> graphSize;
	size = graphSize;//set size
	adj_list.resize(graphSize); //adjust size to the edges for each label
	if(infile.peek() == '\n')
	{
		infile.ignore();
	}
	
	getline(infile, input);
	//add labels from first row
	for(unsigned int i = 0; i < input.size(); ++i)
	{
			if(!isspace(input[i]))
			{
				labels.push_back(input[i]);
			}
		
	}
	//get and assign edges
	unsigned int labelTracker = 0; //tracks which label should be assigned the edges
	while(getline(infile, input) && labelTracker < labels.size())
	{
		unsigned int edgeTracker = 0; //tracks which element we are viewing for a possible edge
		for(unsigned int j = 0; j < input.size() && edgeTracker < adj_list.size(); ++j)
		{
			//if not alpha(for row title) or space, then identify if there is a corresponding edge
			if(!isalpha(input[j]) && !isspace(input[j]))
			{
				//ensures does not attempt to access label outside of memory in case of error
			   if(edgeTracker < labels.size() && input[j] == '1')
				{
					//push back current column label with the index for the label with an edge
					adj_list[labelTracker].push_back(edgeTracker);
				}//end of if
				++edgeTracker;
			}//end of if
		}//end of for
		++labelTracker;
	}//end of while
	
	
	//close file when finished
	infile.close();
	infile.clear();
}

Graph::~Graph()
{

}

/* Used to obtain the size of the graph
@return an integer that depicts the number of vertexs in the graph
*/
int Graph::Getsize() const 
{ 
  return size;	
}

/* Traverses each vertex in the graph and prints out the order of traversal and the vertices of edges
@note This currently traverses in depth first order
*/
void Graph::Traverse() 
{
	cout << "\n------- traverse of graph ------\n";
	
	Depthfirst(0);
	
	cout << "\n";
	for(auto i : edges)
	{
			cout << "(" << labels[i.first] << ", " << labels[i.second] << ") ";
	}
	cout << "\n--------- end of traverse -------\n";
}


/* Prints each vertex of the graph and their corresponding edges
*/
void Graph::Print() const 
{
	cout << "\nNumber of vertices in the graph: " << Getsize() << "\n\n-------- graph -------\n";
	
  for(unsigned int i = 0; i < labels.size() && i < adj_list.size(); ++i)
  {
	  cout << labels[i] << ": ";
	  int comma = 0;
	  for(auto edge : adj_list[i])
	  {
		 if(comma != 0)
		 { cout << ", ";}
		cout << labels[edge];
		++comma;
	  }
	  cout << "\n";
  }
  cout << "------- end of graph ------\n";
}
