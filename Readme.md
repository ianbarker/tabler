# ASCII-table formatter and renderer

## Overview

Simple (in the beginning) helper which can format and render ASCII tables for CLI tools.

Basic usage:

```php
$tabler = (new \eznio\tabler\Tabler())
    ->setHeaders(['a' => 'Column A', 'b' => 'Column B', 'c' => 'Column C'])
    ->setData([
        ['a' => '123', 'b' => '456', 'c' => '7'],
        ['a' => '123', 'b' => '456', 'c' => '7'],
        ['a' => '123', 'b' => '456', 'c' => '7']
    ])
    ->setRenderer(new \eznio\tabler\renderers\MysqlStyleRenderer());
```

which produces

```
+----------+----------+----------+
| Column A | Column B | Column C |
+----------+----------+----------+
| 123      | 456      | 7        |
| 123      | 456      | 7        |
| 123      | 456      | 7        |
+----------+----------+----------+
```

## Basic classes and interfaces

Classes:

 * `Tabler` - facade class for the whole package. Holds some shortcut calls for setting table data, generating, styling and rendering
 * `Composer` - scans headers and data arrays, gathers maximum lengths, composes column structure and tries to get column names if missing 
 * `LayoutBuilder` - gets `Composer` with parsed table data and generates TableLayout structure(-s) (see below)
 * `Styler` - helper to set styles (bg color, fg color, some text styles) for the line of text
 * `Element` - basic class of TableLayout structure 
 
Interfaces:

 * `Renderer` - interface to be implemented by rendering classes

## Table elements

### What and what for

TableLayout is a metastructure representing the whole table and its elements - rows and cells.

This one is useful mostly for styling purposes. For example, if we want to display 2nd column in red color:

```php
$layout = $tabler->getTableLayout();
$layout->getHeaderLine()->getHeaderCell('column2')
    ->setForegroundColor(\eznio\tabler\references\ForegroundColors::RED);
```

### Schema
Overall elements layout and nesting:
```
+-----------------------------------------+
| TableLayout                             |
|                                         |
| +-------------------------------------+ |
| | HeaderLine                          | |
| |                                     | |
| | +------------+ +------------+       | |
| | | HeaderCell | | HeaderCell | . . . | |
| | +------------+ +------------+       | |
| +-------------------------------------+ |
|                                         |
| +-------------------------------------+ |
| | DataGrid                            | |
| |                                     | |
| | +---------------------------------+ | |
| | | DataRow                         | | |
| | |                                 | | |
| | | +----------+ +----------+       | | |
| | | | DataCell | | DataCell | . . . | | |
| | | +----------+ +----------+       | | |
| | +---------------------------------+ | |
| |                                     | |    
| | +---------------------------------+ | |
| | | DataRow                         | | |
| | |                                 | | |
| | | +----------+ +----------+       | | |
| | | | DataCell | | DataCell | . . . | | |
| | | +----------+ +----------+       | | |
| | +---------------------------------+ | |
| |                                     | |
| |  . . .                              | |
| +-------------------------------------+ |
+-----------------------------------------+
```
### Short element reference

 * `TableLayout` - the whole table. Border colors are set here
 * `HeaderLine` - first row with column headers
 * `HeaderCell` - single heading row's cell. 
 * `DataGrid` - overall data part
 * `DataRow` - single data row
 * `DataCell` - single data cell

### Getting/setting child elements

1. Getting TableLayout:
```php
/** @var Tabler $tabler */
$tableLayout = $tabler->getTableLayout();
```

2. Getting top elements:
```php
/** @var HeaderLine $headerLine */
$headerLine = $tableLayout->getheaderLine();

/** @var DataGrid $dataGrid */
$dataGrid = $tableLayout->getDataGrid();
```

3. Getting HeaderLine cells
```php
/** @var HeaderCell $headerCellA */
$headerCellA = $headerLine->getHeaderCell('a');
```

4. Getting data rows and cells
```php
/** @var DataRow $firstDataRow */
$firstDataRow = $dataGrid->getRow(0);

/** @var DataCell $dataCellA */
$dataCellA = $firstDataRow->getCell('a');
```

## Facade public API reference

```php
$tabler = new \eznio\tabler\Tabler();
```

Main part:

 * ```setData(array $data)```
 
   Sets table data 2-level nested array:
   
    * Top-level array elements are treated as rows and should be arrays too
    * Row elements are considered cells. Their array keys are column IDs 
    
 * ```setHeaders(array $headers)```
   
   Sets table headers array. Its elements are counted as column headers, and their array keys are column IDs.
 
 * ```getTableLayout()```
 
   Returns TableLayout structure. If no one is built - builds it before returning.
 
 * ```setRenderer(Renderer $renderer)```
 
   Sets rendering class to render table
   
 * ```setGuessHeaderNames(bool $guessHeaderNames)```
 
   Setting $guessHeaderNames to true means using columnd IDs as header titles if no titles are provided
   
   If $guessHeaderNames is set to false - column names without provided titles are rendered as empty strings
 
 * ```render(TableLayout $tableLayout = null)```
 
   Renders current (if no TableLayout is passed), or given TableLayout component into table string representation and returns it
 
Styling shortcuts:

Descriptions are available in source code if needed

 * ```setBorderBackgroundColor($color)```
 * ```getBorderBackgroundColor()```
 * ```setBorderForegroundColor($color)```
 * ```getBorderForegroundColor()```
 * ```setHeadingLineStyles(array $styles)```
 * ```getHeadingLineStyles()```
 * ```setHeadingCellStyles($columnId, array $styles)```
 * ```getHeadingCellStyles($columnId)```
 * ```setColumnStyles($columnId, array $styles)```
 * ```setColumnTextAlignment($columnId, $alignment)```
 * ```setColumnMinLength($columnId, $minLength)```
 * ```setColumnLeftPadding($columnId, $leftPadding)```
 * ```getColumnLeftPadding($columnId)```
 * ```setColumnRightPadding($columnId, $rightPadding)```
 * ```getColumnRightPadding($columnId)```
 * ```setColumnPadding($columnId, $padding)```
 * ```setRowStyles($rowId, array $styles)```
 * ```setOddRowsStyles(array $styles)```
 * ```setEvenRowsStyles(array $styles)```
 * ```getRowStyles($rowId)```
 * ```setCellStyles($columnId, $rowId, array $styles)```
 * ```getCellStyles($columnId, $rowId)```
 * ```setCellTextAlignment($columnId, $rowId, $alignment)```
 * ```getCellTextAlignment($columnId, $rowId)```

## Styling

### Style arrays

Styles can be set as single value:
```php
$cell->setStyle(ForegroundColors::RED);
```
or array:
```php
$cell->setStyle([
    ForegroundColors::RED,
    BacgroundColors::WHITE,
    TextStyles::BOLD
]);
```
If more that one array element is set from the bg or fg colors - last one is being used. Text styles are free to use in cojunction.

### Style reference classes

 * `references\ForegroundColors`
 * `references\BackgroundColors`
 * `references\TextStyles`

### Styling elements

 * `TableLayout` - set border bg and fg colors
 * `HeaderLine` - set bg/fg/text styles for the whole headers, can be override at `HeaderCell` level  
 * `HeaderCell` - set bg/fg/text styles, minimum length, text alignment and paddings for single header cell, overrides `HeaderLine`-level settings
 * `DataRow` - set bg/fg/text styles and text alignment for single data row, can be override in `DataCell`
 * `DataCell` - set bg/fg/text styles, minimum length, text alignment and paddings for single data cell, overrides `DataRow`-level settings

## Renderers

### Table data

In examples in this part the following Tabler setup will be used:
 
```php
$tabler = (new \eznio\tabler\Tabler())
    ->setHeaders(['a' => 'Column A', 'b' => 'Column B', 'c' => 'Column C'])
    ->setData([
        ['a' => '123', 'b' => '456', 'c' => '7'],
        ['a' => '234', 'b' => '567', 'c' => '8'],
        ['a' => '345', 'b' => '6789', 'c' => '']
    ]);
```

### MySQL-style renderer

```php
$tabler->setRenderer(new MysqlStyleRenderer());
```

```
+----------+----------+----------+
| Column A | Column B | Column C |
+----------+----------+----------+
| 123      | 456      | 7        |
| 234      | 567      | 8        |
| 345      | 6789     |          |
+----------+----------+----------+
```

### MC-style renderer

```php
$tabler->setRenderer(new McStyleRenderer());
```

```
╔══════════╦══════════╦══════════╗
║ Column A ║ Column B ║ Column C ║
╠══════════╬══════════╬══════════╣
║ 123      ║ 456      ║ 7        ║
║ 234      ║ 567      ║ 8        ║
║ 345      ║ 6789     ║          ║
╚══════════╩══════════╩══════════╝
```

### "Clear" styled renderer

```php
$tabler->setRenderer(new ClearStyleRenderer());
```

```
 Column A  Column B  Column C 
    
 123       456       7        
 234       567       8        
 345       6789               
```

### "Single line" styled renderer

```php
$tabler->setRenderer(new SingleLineRenderer());
```

```
┌──────────┬──────────┬──────────┐
│ Column A │ Column B │ Column C │
├──────────┼──────────┼──────────┤
│ 123      │ 456      │ 7        │
│ 234      │ 567      │ 8        │
│ 345      │ 6789     │          │
└──────────┴──────────┴──────────┘          
```