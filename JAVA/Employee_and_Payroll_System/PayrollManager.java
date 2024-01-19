    package com.company;

    import static com.company.TaxManager.ComputeTaxPayment;

    public class PayrollManager
    {
        //calculates the total gross pay, including both regular pay and overtime pay
        public static double CalculateGrossPay (Employee ID, PayPeriod period)
        {
          return (CalculateRegularPay(ID, period) + CalculateOvertimePay(ID, period));
        }

        //calculates only the regular pay, excludes overtime pay
        public static double CalculateRegularPay (Employee ID, PayPeriod period)
        {
            //if employee worked overtime, only calculates the Regular rate for the first 40 hours
            if(period.getNumberOfHours() > 40)
            {
                return (40 * ID.getPayRate());
            }
            //calculates Regular pay rate if employee did not work overtime
            else
            {
                return (period.getNumberOfHours() * ID.getPayRate());
            }
        }

        //calculates only the amount of overtime pay
        public static double CalculateOvertimePay (Employee ID, PayPeriod period)
        {
            //returns 0 if the employee did not work overtime
            if(period.getNumberOfHours() <= 40)
            {
                return 0.0;
            }
            //excludes the first 40 hours worked to return only Overtime pay
            else
            {
                return ((ID.getPayRate() * 1.5) * (period.getNumberOfHours() - 40));
            }
        }

        //prints a pay stub using information from an Employee object and PayPeriod object
        public static void PrintPayStub(Employee ID, PayPeriod period)
        {
            //tracks if employee worked overtime
            boolean Overtime = (period.getNumberOfHours() > 40);

            double regularHours;
            double overtimeHours;

            //sets hours worked based on Overtime
            if(Overtime)
            {
                regularHours = 40;
                overtimeHours = period.getNumberOfHours() - 40;
            }
            else
            {
                regularHours = period.getNumberOfHours();
                overtimeHours = 0;
            }

            //calculates and sets the tax payments
            TaxRates rates = new TaxRates((CalculateGrossPay(ID, period)));
            period.setTaxPayment(ComputeTaxPayment((CalculateGrossPay(ID, period)), rates));

            //calculates the net pay
            double netPay = (CalculateGrossPay(ID, period) - period.getTaxPayment().getFederalTax()
            - period.getTaxPayment().getStateTax() - period.getTaxPayment().getFicaTax());

            //sets separator length and style
            int separatorLength = 50;
            String separator = "_";
            //prints a blank line and a separator
            System.out.println();
            System.out.println(separator.repeat(separatorLength));

            IPrinter Ip = ID.getPrinter();
            Ip.printEmployee(ID);
            //prints out regular pay calculations
            System.out.printf("Regular Pay: %.2f hours at $%.2f", regularHours, ID.getPayRate());
            System.out.printf("/hr: $%.2f%n", CalculateRegularPay(ID, period));

            //prints out overtime pay calculations if employee worked overtime
            if(Overtime)
            {
                System.out.printf("Overtime Pay: %.2f hours at $%.2f", overtimeHours, (ID.getPayRate() * 1.5));
                System.out.printf("/hr: $%.2f%n", CalculateOvertimePay(ID, period));
            }

            //prints gross payroll
            System.out.printf("Gross Total: $%.2f%n", CalculateGrossPay(ID,period));

            //prints a blank line and a separator
            System.out.println(separator.repeat(separatorLength));
            System.out.println();

            //prints the tax payment amounts
            System.out.println("Taxes:");
            System.out.printf("Federal Tax: $%.2f%n", period.getTaxPayment().getFederalTax());
            System.out.printf("State Tax: $%.2f%n", period.getTaxPayment().getStateTax());
            System.out.printf("Fica Tax: $%.2f%n", period.getTaxPayment().getFicaTax());

            //prints a blank line and a separator
            System.out.println(separator.repeat(separatorLength));
            System.out.println();

            //prints the net paycheck amount
            System.out.printf("NetPaycheck:$%.2f%n", netPay);

        }

    }
