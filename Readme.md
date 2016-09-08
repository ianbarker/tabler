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
 * `Composer`
 * `LayoutBuilder`
 * `Styler`
 * `Element` 
 
Interfaces:

 * `Renderer`

## Table elements

Overall layout and nesting:
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

## Facade reference

## Styling