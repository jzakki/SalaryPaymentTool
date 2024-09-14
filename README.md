# Salary Payment Tool

This command-line utility calculates salary and bonus payment dates for a specified date range, supporting multiple calendars and time zones, and allows specifying the output file name.

## Requirements

- PHP 8.1 or higher
- Composer
- PHP Intl extension

## Installation

1. Clone the repository
2. Run `composer install` to set up autoloading

## Usage

1. Open a terminal or command prompt.
2. Navigate to the project directory.
3. Run the following command:

```
php bootstrap.php --output=<filename>
```

Replace `<filename>` with your desired output file name (e.g., `payment_dates.csv`).

Example:
```
php bootstrap.php --output=my_payment_dates.csv
```

4. The script will generate a CSV file with the specified name in the same directory.

## Configuration

You can modify the following in the `bootstrap.php` file:
- Time zone: Change the `DateTimeZone` parameter
- Calendar system: Replace `GregorianCalendar` with other calendar implementations
- Date range: Modify the `$startDate` and `$endDate` variables

## Output

The generated CSV file will contain the following columns:
- Month
- Salary Payment Date
- Bonus Payment Date

## Architecture

This project follows SOLID principles and uses design patterns to ensure maintainability and scalability:

- Single Responsibility Principle: Each class has a single responsibility (e.g., SalaryPayment, BonusPayment, GregorianCalendar).
- Open/Closed Principle: The system is open for extension (e.g., new payment types or calendar systems can be added) but closed for modification.
- Liskov Substitution Principle: PaymentTypeInterface and CalendarInterface ensure that all implementations can be used interchangeably.
- Interface Segregation Principle: Separate interfaces for PaymentType, Calendar, and Exporter.
- Dependency Inversion Principle: High-level modules depend on abstractions (interfaces) rather than concrete implementations.

Design Patterns used:
- Strategy Pattern: Different payment calculation strategies and calendar systems can be easily swapped or extended.
- Dependency Injection: Dependencies are injected into classes, allowing for easy testing and flexibility.

## Extensibility

To add a new payment type:
1. Create a new class implementing the `PaymentTypeInterface`
2. Implement the `calculatePaymentDate` method with the new payment logic
3. Inject the new payment type into the `GeneratePaymentDatesCommand` or create a new command as needed

To add a new calendar system:
1. Create a new class implementing the `CalendarInterface`
2. Implement the calendar-specific logic in the new class
3. Use the new calendar class in the `bootstrap.php` file

## Limitations

- The tool currently uses a fixed time zone and calendar system set in the `bootstrap.php` file.
- Date range is currently fixed in the `bootstrap.php` file.
- Minimal error handling is implemented due to time constraints.

## Future Improvements

- Add unit tests for each class and calendar implementation
- Implement more robust error handling and logging
- Allow for additional command-line arguments to specify date range and time zone
- Add a configuration file for customizable settings
- Implement a factory for creating calendar systems dynamically
- Support for more calendar systems (e.g., Islamic, Hebrew)
- Add localization support for month names and date formats
- Allow specifying the output file format (e.g., CSV, JSON, XML)
