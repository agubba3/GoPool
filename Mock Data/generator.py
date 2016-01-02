import openpyxl

wb = openpyxl.load_workbook('MockData.xlsx')
sheet = wb.get_sheet_by_name('Sheet1')
print sheet['H2'].value
for i in range(1, 66):
	insertPref = "INSERT INTO User"
	valuesPref = "VALUES ("
	for c in range(0, 12):
		ch = chr(ord('A') + c)
		col = ch + str(i)
		if c != 11:
			if sheet[col].value == None:
				valuesPref += "NULL" + ","
			else:
				valuesPref += "\"" + str(sheet[col].value) + "\"" + ","
		else:
			if sheet[col].value == None:
				valuesPref += "NULL" + ");"
			else:
				valuesPref += "\"" + str(sheet[col].value) + "\"" + ");"
	print insertPref
	print valuesPref
	valuesPref = "VALUES ("



