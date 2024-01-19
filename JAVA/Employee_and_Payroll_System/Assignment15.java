// CSC 214
// Author: Sterling Johnson
// Assignment #15:

package com.company;


import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Scanner;
import java.util.Date;

public class TestWork {

    public static void main(String[] args) {

        //creates Scanner object for input
        Scanner in = new Scanner(System.in);

        //creates ArrayList to hold employee info in
        ArrayList<Employee> employeeList = readEmployeeList();

        int input = 0;

        //stays in menu until user chooses exit option
        while (input != 3) {
            System.out.println("\nPLease choose from the following options:\n1. Employee management\n2. Payroll management" +
                    "\n3. Exit");
            input = in.nextInt();
            if (input == 1) {
                //submenu for option 1;
                int subInput = 0;
                //exits submenu when user chooses the exit option
                while (subInput != 3) {
                    System.out.println("\nPLease choose from the following options:\n1. Add Employees\n" +
                            "2. List All Employees\n3. Exit");
                    subInput = in.nextInt();
                    //add employee option
                    if (subInput == 1) {
                        char answer = 'Y';
                        while (answer == 'Y') {
                            Employee employeeInfo = setEmployee();
                            //adds employee info to the array
                            employeeList.add(employeeInfo);
                            //inquires if user wants to add another employee
                            System.out.println("Would you like to add another employee? (Y/N)");
                            answer = in.next().charAt(0);
                            answer = Character.toUpperCase(answer);
                        }
                        //outputs list of employees to a file
                        writeEmployeeList(employeeList);
                    }
                    //print employee option
                    else if (subInput == 2) {
                        //prints a list of all employees
                        printEmployeeList(employeeList);
                    }
                    //exit option for submenu 1
                    else if (subInput == 3) {
                        System.out.println("\nReturning to Main Menu");
                    }
                    //handles error if user inputs incorrect option for submenu 1
                    else {
                        System.out.println("That is not a valid selection. Please try again.\n");
                    }
                }
            } else if (input == 2) {

                //submenu for option 2;
                int subInput = 0;
                while (subInput != 3) {
                    System.out.println("\nPLease choose from the following options:\n1. Import Payroll File\n" +
                            "2. Print Paystubs\n3. Exit");
                    subInput = in.nextInt();

                    //Import payroll file option
                    if (subInput == 1) {
                        importPayrollInfo(employeeList);
                    }
                    //print paystubs options
                    else if (subInput == 2) {
                        //ensures employeeList is not empty
                        if (employeeList.isEmpty()) {
                            System.out.println("There are no employees to print a paystub.\n" +
                                    "Please add an employee to process this option");
                        } else {
                            for (Employee emp : employeeList) {
                                if(emp.getPayPeriodList().isEmpty())
                                {
                                    System.out.println("There are no payperiods for the employee ID " +
                                            emp.getEmpID() + ".\nPlease add a payperiod for this employee.");
                                }
                                else
                                {
                                    PayrollManager.PrintPayStub(emp, emp.getPayPeriodList().get(0));
                                }
                            }
                        }
                    }
                    //exit option for submenu 2
                    else if (subInput == 3) {
                        System.out.println("\nReturning to Main Menu");
                    }
                    //handles error if user inputs incorrect option for submenu 2
                    else {
                        System.out.println("That is not a valid selection. Please try again.\n");
                    }
                }
            }
            //exit option for main menu
            else if (input == 3) {
                System.out.println("Thank you for using our service!\nHave a great day\n");
            }
            //handles error if user inputs incorrect option for main menu
            else {
                System.out.println("That is not a valid selection. Please try again.\n");
            }
        }


    }

    //outputs employee list to a file
    public static void writeEmployeeList(ArrayList<Employee> empList) {
        String outFilename = "output.txt";
        try {
            PrintWriter out = new PrintWriter(outFilename);
            for (Employee emp : empList) {
                out.println(emp.serialize());
            }
            out.close();

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }
    }

    public static void importPayrollInfo(ArrayList<Employee> empList) {
        Scanner in = new Scanner(System.in);
        System.out.println("What is the name of the file you would like to import? ");
        String fileName = in.next();
        File inputFile = new File(fileName);
        try
        {
            Scanner inFile = new Scanner(inputFile);
            double totalHours = 0;
            double hours;
            int numOfEmpsAdded = 0;
            int ID;
            String input;
            while (inFile.hasNextLine()) {
                input = inFile.next();
                ID = Integer.parseInt(input.trim());
                input = inFile.next();
                hours = Double.parseDouble(input.trim());
                //searches for ID in employeeList
                int pos = 0;
                boolean found = false;
                for (int i = 0; i < empList.size() && !found; ++i) {
                    if (empList.get(i).getEmpID() == ID) {
                        found = true;
                        pos = i;
                    }
                }
                if (found) {
                    //temporarily setting up default dates
                    Calendar calendar = Calendar.getInstance();
                    calendar.set(2021, 11, 19);
                    Date beginPayPeriod = calendar.getTime();
                    calendar.set(2021, 12, 3);
                    Date endPayPeriod = calendar.getTime();

                    PayPeriod tempPayPeriod = new PayPeriod(1, empList.get(pos).getEmpID(), beginPayPeriod, endPayPeriod, hours);
                    empList.get(pos).addPayPeriod(tempPayPeriod);
                    totalHours += hours;
                    numOfEmpsAdded++;
                } else {
                    System.out.println("Unable to locate employee ID " + ID +
                            "\nThe payroll information for this employee has not been added");
                }
            }
            inFile.close();
            System.out.println("Summary\n_________\nTotal number of hours entered: " + totalHours +
                                "\nNumber of employees entered: " + numOfEmpsAdded);
        }
        catch (FileNotFoundException e)
        {
            e.printStackTrace();
        }
    }

    public static ArrayList<Employee> readEmployeeList() {

        File inputFile = new File("output.txt");
        ArrayList<Employee> tempEmpList = new ArrayList<Employee>();
        try {
            Scanner inFile = new Scanner(inputFile);
            while (inFile.hasNextLine())
            {
                char role = inFile.next().charAt(0);
                String input = inFile.next();
                int employeeID = Integer.parseInt(input.trim());


                String employeeLastName = inFile.next();
                String employeeFirstName = inFile.next();
                char employeeMiddleInitial = inFile.next().charAt(0);


                inFile.nextLine();
                String employeeStreetAddress = inFile.nextLine();
                String employeeCity = inFile.nextLine();


                input = inFile.next();
                int employeeZipCode = Integer.parseInt(input.trim());

                String employeePhoneNumber = inFile.next();
                String employeeEmail = inFile.next();

                input = inFile.next();
                double payRate = Double.parseDouble(input.trim());

                input = inFile.next();
                double annualBonus = Double.parseDouble(input.trim());


                Employee employeeInfo;
                if (role == 'M') {
                    employeeInfo = new Manager(employeeFirstName, employeeMiddleInitial, employeeLastName, employeeID, payRate,
                            employeeStreetAddress, employeeCity, employeeZipCode, employeePhoneNumber, employeeEmail, annualBonus);
                } else {
                    employeeInfo = new Employee(employeeFirstName, employeeMiddleInitial, employeeLastName, employeeID, payRate,
                            employeeStreetAddress, employeeCity, employeeZipCode, employeePhoneNumber, employeeEmail);
                }
                tempEmpList.add(employeeInfo);

            }
            inFile.close();
        }
        catch (FileNotFoundException e)
        {
            e.printStackTrace();
        }
        return tempEmpList;
    }


    //prints employee list
    public static void printEmployeeList(ArrayList<Employee> empList) {
        //begins formatting process to print list of employees names
        System.out.println("Employee List");
        //sets separator length and style
        int separatorLength = 50;
        String separator = "_";
        System.out.println(separator.repeat(separatorLength));
        System.out.println("ID Name");
        System.out.println(separator.repeat(separatorLength));
        System.out.println();

        //prints list of employee names
        int listCounter = 1; // track numbers of employees printed
        for (Employee emp : empList) {
            System.out.println(listCounter + "  " + emp.getEmpFirstName() + " " + emp.getEmpLastName());
            listCounter++;
        }
    }

    //inputs the employee's information from the user to create an Employee objects
    public static Employee setEmployee() {
        //creates Scanner object for input
        Scanner in = new Scanner(System.in);

        //receives input for employee information
        System.out.print("Enter Employee ID: ");
        int employeeID = in.nextInt();

        System.out.print("Enter Employee first name: ");
        String employeeFirstName = in.next();

        System.out.print("Enter Employee middle initial: ");
        char employeeMiddleInitial = in.next().charAt(0);

        System.out.print("Enter Employee last name: ");
        String employeeLastName = in.next();

        System.out.print("Enter Employee's  street address: ");
        in.nextLine();
        String employeeStreetAddress = in.nextLine();

        System.out.print("Enter Employee's city: ");
        String employeeCity = in.nextLine();

        System.out.print("Enter Employee's zip code: ");
        int employeeZipCode = in.nextInt();

        System.out.print("Enter Employee's phone number(Ex: 123-456-7890): ");
        String employeePhoneNumber = in.next();

        System.out.print("Enter Employee's email: ");
        String employeeEmail = in.next();

        System.out.print("Enter hourly rate of pay: ");
        double payRate = in.nextDouble();

        System.out.print("Is this employee a manager? (Y/N)");
        char answer;
        answer = in.next().charAt(0);
        answer = Character.toUpperCase(answer);

        Employee employeeInfo;
        if (answer == 'Y') {
            System.out.print("What is their annual bonus? ");
            double annualBonus = in.nextDouble();

            //creates a manager object if employee is a manager
            employeeInfo = new Manager(employeeFirstName, employeeMiddleInitial, employeeLastName, employeeID, payRate,
                    employeeStreetAddress, employeeCity, employeeZipCode, employeePhoneNumber, employeeEmail, annualBonus);
        } else {
            //creates an employee object if they are not a manager
            employeeInfo = new Employee(employeeFirstName, employeeMiddleInitial, employeeLastName, employeeID, payRate,
                    employeeStreetAddress, employeeCity, employeeZipCode, employeePhoneNumber, employeeEmail);
        }

        return employeeInfo;
    }

}

