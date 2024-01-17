# COBOL
These are two of the example programs that I created during my Mainframe Applications college course in the Fall of 2023.

The files I have included are the job outputs for these submissions. These were included instead of the raw code, so you could view the condition codes and the output from the program. The output for the programs can be viewed by scrolling to the end of the files. These were created on IBM's z/OS utilizing Marist's system.
 

COBOL_Input_and_Output_Files
-------------------------------

* This file takes in an unknown number of sales records for a specific fund and writes them to standard output in a specified format.
* The first record provides details of the specific fund these sales relate to.
* This includes the fund name, the share price and the three commission percentages a broker can earn from a sale for this fund.
* The remaining records are sales for that specified fund.
* This includes the branch location, the name of the broker, the deposit amount for the sale, and a number 1-3 correlating to the commission percent the broker will receive. 
* For each sale, the program prints the branch location of the broker who initiated the sale, the name of the broker, the deposit amount for the sale, the calculated share amount(based on the deposit amount for the sale and the share price for the fund that was provided in the first record),and the calculated commission(this is based on the commission percent assigned to the sale and the deposit amount for the sale).
* Note: The share amount is printed with an extra zero at the end, based on the assignment specifications.
* If the broker sold more than 50,000 shares, the program adds the sale information to a highsale dataset.
* After all sales have been read, the program outputs the total number of sales, total deposit amount (which is named "TOTAL SALES AMOUNT" based on the assignment requirements), the total shares sold, and the total commission the broker's earned.
* Then the program reads the highsale dataset and prints the name of each broker that sold more than 50,000 shares and the number of shares sold.
* After reading the entire highsale dataset, the program outputs the total number of high sales brokers and the total number of shares sold by these brokers.
* The program also prints a header for each page of information. Up to 18 lines of sales are printed on each page. The totals are printed on separate pages. The page numbers restart between the sales records and the high-sales information.


COBOL_Tables_With_Assembler_SubProgram
---------------------------------------
* This program is similar to the previous file, but it utilizes COBOL Tables to allow the processing of multiple fund's sales.
* The file is also broken down into multiple subprograms and contains one assembler subprogram due to the assignment's specification.

JOB STEPS:
* JSTEP01 -
This job step uses IBM's DFSORT utility to sort the funds dataset in ascending order by fund ID. 
* JSTEP02 -
This job compiles the SALESRPT COBOL program into an object module using the COBOL compiler IGYCRCTLY.
* JSTEP03 -
Step 3 compiles the assembler program CALCSHRS into an object module, using ASMA90.
* JSTEP04 -
Next the HISALES is compiled into an object module using the COBOL compiler IGYCRCTLY.
* JSTEP05 -
This step binds the object modules from the 3 previous steps (for programs HISALES, CALCSHRS and SALESRPT) into a program object, using the 	binder HEWL.
* JSTEP06 -
Step 6 compiles the program BUILDTBL into a object module using the COBOL compiler IGYCRCTLY.
* JSTEP07 -
Step 7 binds the object module from the previous step into a program object, using the binder HEWL.
* JSTEP08 -
The final step executes the load module/ program object created in job step 5.

Subprograms:
* SALESRPT -
	* This is the main program that controls the flow and calls all the other subprograms.
	* First, the program calls the subprogram BUILDTBL using FUND-TBL to build a table to store information for each fund(see BUILD TBL).
	* It then reads the SALES-FILE and prints out the sales for each broker. 
		o With the specifications provided, each broker could have up to 4 sales. 
		o The program prints out the broker s name and the branch they are located at and the Deposit amount for each sale and fund number for the sale. It also searches for the fund number provided for the sale. If the fund number is found in the table, it prints the fund name and calculates the share amount and commission. If it's not found, then "** SALE FUND NOT FOUND **" is printed in place of the fund name and the share amount and commission amount are not calculated and in turn not able to be added to the totals.
	* If the share amount needs to be calculated, the program calls the subprogram CALCSHRS using the DEP-AMT, SHR-PRC, and SHR-AMT variables.
	* If a broker sells more than 10,000 shares, then the program adds them to the HIGH-SALE-RECORD.
	* After all the sales records have been read, the program prints out the total amount of brokers, sales, deposit amounts and commission amounts. 
	* Finally, the program calls the subprogram HISALES using HEADER1, HEADER2, and the FUND-TBL.
	* The program also prints a header for each page of information. Up to 18 lines of sales are printed on each page. The totals are printed on seperate pages.
* CALCSHRS -
	* This is an assembler program used to calculate the share amount. This was implemented as an assembler program based on the assignment's 	specification. 
	* The program utilizes the first parameter, deposit amount, and the second parameter, share price, to calculate and return the share amount. The calculated share amount is stored and returned in the third parameter provided by SALESRPT.
* HISALES -
	* This program is utilized to read the HIGH-SALE-FILE that the SALESRPT program wrote to.
	* It prints the broker s name, fund number and share amount that was written to the dataset. It also searches the FUNDTBL using the fund number provided to find and print the fund name.
	* After reading the information for each high sale broker, the program prints the total number of high sales and high sale brokers.
	* The program also prints a header for each page of information. Up to 18 lines of sales are printed on each page. The totals are printed on separate pages.
* BUILDTBL -
	* This program is used to build a table that stores the fund's number, fund's name, commission percent, and the varying share prices. In this 	situation, the fund could have up to four different share prices based on the tenure of the broker (Although that is not a realistic example, that was the requirement of this program). 
	* The program first reads from the FUND-FILE and fills the first dimension of the FUNDTBL filling in the fund name, fund number and fund 	commission percent, and the TBL-FUND-CTR based on how many funds were found, up to 199. 
	* It then fills in the second dimension of the table and adds all of the share prices for each fund using the PRICE-RECORD file.
