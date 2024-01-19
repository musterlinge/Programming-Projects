package com.company;

public class TaxManager {

    //added the incremental tax rates to my taxRates class instead, it just made more sense to me
    public static TaxPayment ComputeTaxPayment(double grossPay, TaxRates taxRates)
    {
        double federalTaxes = (grossPay * taxRates.getFederalTax());
        double stateTaxes = (grossPay * taxRates.getStateRate());
        double ficaTaxes = (grossPay * taxRates.getFicaRate());

        TaxPayment tempTaxPayment= new TaxPayment(federalTaxes, stateTaxes, ficaTaxes);

        return tempTaxPayment;
    }
}
