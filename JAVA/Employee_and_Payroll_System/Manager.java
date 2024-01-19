package com.company;

public class Manager extends Employee
{
    private double annualBonus;

    public Manager() {}
    public Manager (String empF, char empM, String empL, int empId, double payR, String empA, String empC, int empZ,
                    String empP, String empE, double annualB)
    {
        super(empF, empM, empL, empId, payR, empA, empC, empZ, empP, empE);
        setAnnualBonus(annualB);

    }

    //accessor
    public void setAnnualBonus(double annB)
    {
        annualBonus = annB;
    }
    //mutator
    public double getAnnualBonus()
    {
        return annualBonus;
    }

    //identifies which printer to use
    public IPrinter getPrinter()
    {
        return new ManagerPrinter();
    }

    //changes all instance variable to a string to store in a file
    public String serialize()
    {
        return ("Manager\n" + getEmpID() + "\n" + getEmpLastName() + " " + getEmpFirstName() + " " + getEmpMiddleInitial()
                + "\n" + getEmpAddress() + "\n" + getEmpCity() + "\n" + getEmpZip() + "\n" + getEmpEmail() + "\n" +
                getEmpPhone() + "\n" + getPayRate() + "\n" + getAnnualBonus());
    }
}
