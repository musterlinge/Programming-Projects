package com.company;

import java.util.ArrayList;

public class Employee {

    private String empFirstName;
    private char empMiddleInitial;
    private String empLastName;
    private int empID;
    private double payRate;
    private String empAddress;
    private String empCity;
    private int empZip;
    private String empPhone;
    private String empEmail;
    private ArrayList<PayPeriod> payPeriodList;

    public Employee () {payPeriodList = new ArrayList<PayPeriod>(); }
    public Employee (String empF, char empM, String empL, int empId, double payR, String empA, String empC, int empZ,
                     String empP, String empE)
    {
        setEmpFirstName(empF);
        setEmpMiddleInitial(empM);
        setEmpLastName(empL);
        setEmpID(empId);
        setPayRate(payR);
        setEmpAddress(empA);
        setEmpCity(empC);
        setEmpZip(empZ);
        setEmpPhone(empP);
        setEmpEmail(empE);
       payPeriodList = new ArrayList<PayPeriod>();

    }

    //accessors
    public String getEmpFirstName(){return empFirstName;}
    public char getEmpMiddleInitial() {return empMiddleInitial;}
    public String getEmpLastName()
    {
        return empLastName;
    }
    public int getEmpID() {return empID;}
    public double getPayRate()
    {
        return payRate;
    }
    public String getEmpAddress() {return empAddress;}
    public String getEmpCity() {return empCity;}
    public int getEmpZip() {return empZip;}
    public String getEmpPhone() {return empPhone;}
    public String getEmpEmail() {return empEmail;}
    public ArrayList<PayPeriod> getPayPeriodList() {return payPeriodList;}

    //mutators
    public void setEmpFirstName(String empF) {empFirstName = empF;}
    public void setEmpMiddleInitial(char empM) {empMiddleInitial = empM;}
    public void setEmpLastName(String empL)
    {
        empLastName = empL;
    }
    public void setEmpID(int empId)
    {
        empID = empId;
    }
    public void setPayRate(double payR)
    {
        payRate = payR;
    }
    public void setEmpAddress(String address) {empAddress = address;}
    public void setEmpCity(String city) {empCity = city;}
    public void setEmpZip(int zip) {empZip = zip;}
    public void setEmpPhone(String empP) {empPhone = empP;}
    public void setEmpEmail(String email) {empEmail = email;}

    public void addPayPeriod(PayPeriod payP) {payPeriodList.add(payP);}

    public IPrinter getPrinter()
    {
        return new EmployeePrinter();
    }

    public String serialize()
    {
        return ("Employee\n" + getEmpID() + "\n" + getEmpLastName() + " " + getEmpFirstName() + " " + getEmpMiddleInitial()
                + "\n" + getEmpAddress() + "\n" + getEmpCity() + "\n" + getEmpZip() + "\n" + getEmpEmail() + "\n"
                + getEmpPhone() + "\n" + getPayRate() + "\n0");
    }

}

