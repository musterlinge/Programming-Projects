package com.company;

import java.util.Date;

public class PayPeriod
{
    private int payPeriodID;
    private int employeeID;
    private Date startDate;
    private Date endDate;
    private double numberOfHours;
    TaxPayment taxPayment;

    //constructor
    public PayPeriod () {}
    public PayPeriod (int pPID, int eID, Date sDate, Date eDate, double nOHours)
    {
        setPayPeriodID(pPID);
        setEmployeeID(eID);
        setStartDate(sDate);
        setEndDate(eDate);
        setNumberOfHours(nOHours);
    }

    //accessors
    public int getPayPeriodID()
    {
        return payPeriodID;
    }
    public int getEmployeeID()
    {
        return employeeID;
    }
    public Date getStartDate()
    {
        return startDate;
    }
    public Date getEndDate()
    {
        return endDate;
    }
    public double getNumberOfHours(){return numberOfHours;}
    public TaxPayment getTaxPayment() {return taxPayment;}

    //mutators
    public void setPayPeriodID(int pID)
    {
        payPeriodID = pID;
    }
    public void setEmployeeID(int eID)
    {
        employeeID = eID;
    }
    public void setStartDate(Date sDate)
    {
        startDate = sDate;
    }
    public void setEndDate(Date eDate)
    {
        endDate = eDate;
    }
    public void setNumberOfHours(double nOHours)
    {
        numberOfHours = nOHours;
    }
    public void setTaxPayment(TaxPayment tPayment) {taxPayment = tPayment;}

}
