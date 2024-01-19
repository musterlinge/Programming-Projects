package com.company;

public class TaxRates {

    private double FederalRate;
    private double StateRate;
    private double FicaRate;

    //constructor
    public TaxRates() {}
    public TaxRates(double federalRate, double stateRate, double ficaRate)
    {
        setFederalRate(federalRate);
        setStateRate(stateRate);
        setFicaRate(ficaRate);
    }
    //sets based on grossPay
    public TaxRates(double grossPay)
    {
        setTaxRates(grossPay);
    }

    //accessors
    public double getFederalTax() {return FederalRate;}
    public double getStateRate() {return StateRate;}
    public double getFicaRate() {return FicaRate;}

    //mutators
    public void setFederalRate(double federalRate) {FederalRate = federalRate;}
    public void setStateRate(double stateRate) {StateRate = stateRate;}
    public void setFicaRate(double ficaRate) {FicaRate = ficaRate;}

    //sets taxRates based on annual gross pay
    public void setTaxRates(double grossPay)
    {
        double annualGrossPay = grossPay * 26.0;
        if(annualGrossPay >= 50000.00)
        {
            setFederalRate(.25);
        }
        else if(annualGrossPay >= 25000.00)
        {
            setFederalRate(.20);
        }
        else if(annualGrossPay >= 10001.00)
        {
            setFederalRate(.15);
        }
        else
        {
            setFederalRate(.10);
        }
        setStateRate(.05);
        setFicaRate(.0765);

    }
}
