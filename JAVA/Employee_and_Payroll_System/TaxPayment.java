package com.company;

public class TaxPayment {

    private double FederalTax;
    private double StateTax;
    private double FicaTax;

    //constructors
    public TaxPayment() {}
    public TaxPayment(double fTax, double sTax, double ficaT)
    {
        setFederalTax(fTax);
        setStateTax(sTax);
        setFicaTax(ficaT);
    }

    //accessors
    public double getFederalTax() {return FederalTax;}
    public double getStateTax() {return StateTax;}
    public double getFicaTax() {return FicaTax;}

    //mutators
    public void setFederalTax(double fTax) {FederalTax = fTax;}
    public void setStateTax(double sTax) {StateTax = sTax;}
    public void setFicaTax(double ficaT) {FicaTax = ficaT;}
}
