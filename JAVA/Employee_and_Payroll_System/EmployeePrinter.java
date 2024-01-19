package com.company;

import com.company.IPrinter;

public class EmployeePrinter implements IPrinter
{
        //prints the employee's personal information
        public void printEmployee(com.company.Employee emp)
        {
            System.out.printf("Employee Id: %d%n", emp.getEmpID());
            System.out.printf("Last Name: %s  First Name: %s  Middle Initial: %s%n", emp.getEmpLastName(), emp.getEmpFirstName(),
                    emp.getEmpMiddleInitial());
            System.out.println("Address: " + emp.getEmpAddress() + ", " + emp.getEmpCity() + ", " + emp.getEmpZip());
            System.out.println("Phone: " + emp.getEmpPhone() + " Email: " + emp.getEmpEmail());
            System.out.println("Role: Employee");
        }

}