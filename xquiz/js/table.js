var INPUT_NAME_PREFIX = 'answers'; // this is being set via script
var RADIO_NAME = 'corrects'; // this is being set via script
var TABLE_NAME = 'tblQuiz'; // this should be named in the HTML
var ROW_BASE = 1; // first number (for display)
var hasLoaded = false;
var DELETE_IMAGE = 'http://localhost/CMS/xps233/htdocs/modules/quiz/images/delete.png';

window.onload=xquiz_fillInRows;

function xquiz_fillInRows()
{
	hasLoaded = true;
}

// CONFIG:
// xquiz_myRowObject is an object for storing information about the table rows
function xquiz_myRowObject(one, two, three)
{
	this.one = one; // text object
	this.two = two; // input text object
	this.three = three; // input checkbox or radio object
}

/*
 * xquiz_addRowToTable
 * Inserts at row 'num', or appends to the end if no arguments are passed in. Don't pass in empty strings.
 */
function xquiz_addRowToTable(num,op)
{
	if (hasLoaded) {
		var tbl = document.getElementById(TABLE_NAME);
		var nextRow = tbl.tBodies[0].rows.length;
		var iteration = nextRow + ROW_BASE;
		if (num == null) { 
			num = nextRow;
		} else {
			iteration = num + ROW_BASE;
		}
		
		// add the row
		var row = tbl.tBodies[0].insertRow(num);
		
		// CONFIG: requires classes named classy0 and classy1
		row.className = 'classy' + (iteration % 2);
	
		// CONFIG: This whole section can be configured
		
		var i = 0;
		// cell 0 - sequence text
		var cell0 = row.insertCell(i);
		var textNode = document.createTextNode(iteration);
		cell0.appendChild(textNode);
		i++;
		
		// cell 1- input radio and checkbox
		if(op != 'blank')
		{
			var cell3 = row.insertCell(i);
			var raEl;
			if(op == 'radio')
			{
				try {
					raEl = document.createElement('<input type="radio" name="' + RADIO_NAME + '" value="' + iteration + '">');
					var failIfNotIE = raEl.name.length;
				} catch(ex) {
					raEl = document.createElement('input');
					raEl.setAttribute('type', 'radio');
					raEl.setAttribute('name', RADIO_NAME);
					raEl.setAttribute('value', iteration);
				}
			}else
			{
				try {
					raEl = document.createElement('<input type="checkbox" name="' + RADIO_NAME + '[' + iteration + ']" >');
					var failIfNotIE = raEl.name.length;
				} catch(ex) {
					raEl = document.createElement('input');
					raEl.setAttribute('type', 'checkbox');
					raEl.setAttribute('name', RADIO_NAME + '[' + iteration + ']');
				}
			}
			cell3.appendChild(raEl);
			i++;
		}
		// cell 2- input text
		var cell1 = row.insertCell(i);
		var txtInp = document.createElement('input');
		txtInp.setAttribute('type', 'text');
		txtInp.setAttribute('name', INPUT_NAME_PREFIX + '[' + iteration + ']');
		txtInp.setAttribute('size', '40');
		txtInp.setAttribute('value', iteration); // iteration included for debug purposes
		cell1.appendChild(txtInp);
		i++;
		
		// cell 3 - Delete Image
		var cell2 = row.insertCell(i);
		var btnEl = document.createElement('img');
		btnEl.setAttribute('src', DELETE_IMAGE);
		btnEl.setAttribute('title', 'Delete');
		btnEl.onclick = function () {xquiz_deleteCurrentRow(this)};
		cell2.appendChild(btnEl);
		
		// Pass in the elements you want to reference later
		// Store the myRow object in each row
		row.myRow = new xquiz_myRowObject(textNode, txtInp, raEl);
	}
}


// If there isn't an element with an onclick event in your row, then this function can't be used.
function xquiz_deleteCurrentRow(obj)
{
	if (hasLoaded) {
		var delRow = obj.parentNode.parentNode;
		var tbl = delRow.parentNode.parentNode;
		var rIndex = delRow.sectionRowIndex;
		var rowArray = new Array(delRow);
		xquiz_deleteRows(rowArray);
		xquiz_reorderRows(tbl, rIndex);
	}
}

function xquiz_reorderRows(tbl, startingIndex)
{
	if (hasLoaded) {
		if (tbl.tBodies[0].rows[startingIndex]) {
			var count = startingIndex + ROW_BASE;
			for (var i=startingIndex; i<tbl.tBodies[0].rows.length; i++) {
			
				// CONFIG: next line is affected by xquiz_myRowObject settings
				tbl.tBodies[0].rows[i].myRow.one.data = count; // text
				//tbl.tBodies[0].rows[i].myRow.one.value = count; // text
				
				// CONFIG: next line is affected by xquiz_myRowObject settings
				tbl.tBodies[0].rows[i].myRow.two.name = INPUT_NAME_PREFIX + '[' + count + ']'; // input text
				if(tbl.tBodies[0].rows[i].myRow.three.type == 'radio')
					tbl.tBodies[0].rows[i].myRow.three.value = count;
				else
					tbl.tBodies[0].rows[i].myRow.three.name = RADIO_NAME + '[' + count + ']';
				
				// CONFIG: next line is affected by xquiz_myRowObject settings
				var tempVal = tbl.tBodies[0].rows[i].myRow.two.value.split(' '); // for debug purposes
				tbl.tBodies[0].rows[i].myRow.two.value = tempVal[0]; // for debug purposes
				
				
				// CONFIG: requires class named classy0 and classy1
				tbl.tBodies[0].rows[i].className = 'classy' + (count % 2);
				
				count++;
			}
		}
	}
}

function xquiz_deleteRows(rowObjArray)
{
	if (hasLoaded) {
		for (var i=0; i<rowObjArray.length; i++) {
			var rIndex = rowObjArray[i].sectionRowIndex;
			rowObjArray[i].parentNode.deleteRow(rIndex);
		}
	}
}