
# php-col-doc
## Simple Command line PHP Documentation Generator

Free GPL Command line php documentation tool that generates *beautiful* php documentation
from source code.

Command Line:

	php-col-doc <inputFiles> <inputFolders> [-o <outputFolder>]

Command line usage examples:

	php-col-doc
	php-col-doc .
	php-col-doc folder
	php-col-doc folder -o ../docs/
	php-col-doc folder -o /var/www/html/docs/
	php-col-doc folder1 folder2 ../folder3 /var/www/html/folder4
	php-col-doc filename.php filename2.php filename3.php -o ./docs/

Output is stored at:
	./php-col-doc/index.html
	./php-col-doc/index.pdf

## Project Objective
The main job of this software is to:
- parse the source code
- generate dot file generation/html

## The Process:
- break all work in small 1 hour tasks with simple defined algorithms
- provide default dumb implementations of all algorithms with wish-list
- see who gets the most done and award hard work.
- learn from each other's code


## Side missions:
if we get enough time we can:
- generate xml?
- Generate Print PDF.
- TODO analysis

## The Object Model

This programs needs classes to represent it's internal objects:
Here is **a** proposed structure, this structure can be subject to change.

- PHPFile
  * getComments()
  * getFunctionList()
  * getClassList()
- PHPClass
  * getMethodList()
  * getComments()  
- PHPMethod
  * getName()
  * getComments()

- PHPFunction
  * getName()
  * getComments()

- PHPConstant
  * getName()
  * getComments()


The program builds an object tree from source code and then
converts the tree model into html/pdf

##The Sample Input

	Sample Simple PHP programs

### input.php
	

	<?php
	/** This is a comment*/
	function functionName(){
		
	}
	/** This is a comment*/
	function functionName2(){
		
	}
	/** This is a comment*/
	function functionName3(){
		
	}
	
## The Expected Output

Sample Output HTML File:
	
	<html>
	<head>
	<style>
	/* a large stylesheet here.*/
	</style>
	</head>
		<body>
			<h1>input.php</h1>
			<ul>
				<li><a href='#functionName'>functionName</a></li>
				<li><a href='#functionName2'>functionName2</a></li>
				<li><a href='#functionName3'>functionName3</a></li>
			</ul>

			<a name='functionName'></a>
			<h2>functionName</h2>
			<p>This is a comment</p>

			<a name='functionName2'></a>
			<h2>functionName2</h2>
			<p>This is a comment</p>


			<a name='functionName3'></a>
			<h2>functionName3</h2>
			<p>This is a comment</p>
		</body>
	</html>


# Master List of Algorithms

## PHPCOL::Source2ClassList(sourceCodeLines)
takes as input a string with \n (line breaks) as line separators and returns 
an array with all the classes defined inside a file
### INPUT:
		

		01. <?php
		02. class Class1 {
		03.	function function1(){
		04.	
		05.	}
		06.	
		07.	
		08.	function function2{
		09.	
		10.	}
		11. }	
		12. /** This is a class comment. */	
		13. class Class2	
		14. {	
		15.	
		16.	
		17. }	
		18. class Class3 { /*code */ }	
		19. ?>
		

### OUTPUT:
		resulting array looks like this:

		array(
			'Class1'=>array('start_line'=>1,'end_line'=>12,'comment'=>'')
			'Class2'=>array('start_line'=>14,'end_line'=>17,'comment'=>'This is a class comment.')
			'Class3'=>array('start_line'=>18,'end_line'=>18,'comment'=>'')
			)
		


## PHPCOL::File2FunctionList(sourceCodeLines)
returns an array with all the functions defined inside a file
### INPUT:
		

		01. <?php
		02.	function function1(){
		04.	
		05.	}
		06.	
		07.     /** a fine comment */	
		08.	function function2{
		09.	
		10.	
		11. }	
		19. ?>
		

### OUTPUT:
		resulting array looks like this:

		array(
			'function1'=>array('start_line'=>2,'end_line'=>5,'comment'=>'')
			'function2'=>array('start_line'=>8,'end_line'=>10,'comment'=>'a fine comment')
			)
		
## PHPCOL::GetHTMLHeader()
returns an html header that inlines the css
so no external css files are required and generates
beautiful code, most of the eye candy lives here

## PHPCOL::File2HTML(filename)
	takes as a source a File and returns a bunch of html

### INPUT:
	input.php
	

	<?php
	/** This is a comment*/
	function functionName(){
		
	}
	/** This is a comment*/
	function functionName2(){
		
	}
	/** This is a comment*/
	function functionName3(){
		
	}

	
### OUTPUT:


	<h1>input</h1>
	<ul>
		<li><a href='#functionName'>functionName</a></li>
		<li><a href='#functionName2'>functionName2</a></li>
		<li><a href='#functionName3'>functionName3</a></li>
	</ul>

	<a name='functionName'></a>
	<h2>functionName</h2>
	<p>This is a comment</p>

	<a name='functionName2'></a>
	<h2>functionName2</h2>
	<p>This is a comment</p>


	<a name='functionName3'></a>
	<h2>functionName3</h2>
	<p>This is a comment</p>

	

## PHPCOL::BuildPDF(htmlFolder)
takes as input folder with a bunch of html files, concatenates
these files together and runs **wkhtmltopdf** on these files to build a 
single PDF File

## PHPCOL::GetAllConstants(sourceCode)
	  returns an array with the defined constants of the file.
	  these constants are later turn into html for the file2html func.a
### INPUT
	  <?php
	  define('CONSTANT','value');
	  define('CONSTANT2','value');
	  /** a fine comment*/
	  define('CONSTANT3','value');
	  ?>
### OUTPUT:
	array(
		'CONSTANT'=>array('comment'=>'')
		'CONSTANT2'=>array('comment'=>'')
		'CONSTANT3'=>array('comment'=>'a fine comment')
	)

## PHPCOL::Function2HTML(functionObj)
		takes a a source a function OBJECT and generates html
## PHPCOL::Class2HTML(classObj)
		takes a a source a class OBJECT and generates html
		
## PHPCOL::Comment2HTML(commentSourceCode)
		takes a comment and converts all characters like < and >
		into characters such as &lt; and &gt; so that these
		are scaped properly and don't damage the layout of the
		generated document.
		it also removes any asterisks from the beginning of the lines.

## PHPCOL::PHPFile2Obj(fileName)
		takes a file as input and generates an object tree as output

## PHPCOL::Obj2Index(objTree)
		takes an object tree as input and generates an
		list of local html links i.e. (<a href=#name>name</a>) as 
		output.

## PHPCOL::Folder2FileList(folderName)
		turns a folder name into a recursive list of relevant files
		relevant files may include php, php3, php5, files that have
		no extension but have a shebang on the first line invoking the
		php command line interpreter.

## PHPCOL::FileList2Index(fileList)
		builds an <li> list of fields for ease of use

		example output:
		

		<ul>
			<li>/a/b.php</a>
			<li>/a/c.php</a>
			<li>/a/e.php</a>
			<li>/a/f.php</a>
		</ul>
		


## PHPCOL::FileList2HTML(fileList)
		Takes a file list as input and generates a bunch of html
		as output
		each input file can have an output

## PHPCOL::PersistProject(fileList)
	persists all files on disk one at a time.

## PHPCOL::PersistFile(fileName, htmlContents)
	Writes results to disk, one input per file at a time.
		
## PHPCOL::ValidateCLIArguments(ARGV)
	validates the existance of the input files and
	provides an error if any of the input files don't exist.

	if no arguments are provided the local index file is used
	./index.php



# License

Community must vote on the license of the project, here are some example
license we can use on the project.

* GPL (no commercial use)
* BSD (allows commercial use)
* Dual Licensing

Do keep in mind better open source tools for this job exist, so it is
a little pointless to try to convert this into a business IMHO.

# Comments
Comments?, suggestions?
Feel free to email me at dataf4l@gmail.com (notice it is not 41, but 4l)


