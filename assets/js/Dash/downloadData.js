
function downloadAll() {
    exportToExcel(jsonData);
}

function exportSelected(){
    exportSelectedData(jsonData);

}

function downloadAdminSelectedData(){
    exportAdminSelectedData(jsonData);
}

function downloadAdminAllData(){
    exportAdminAllData(jsonData);
}


// download all data
function exportAdminAllData(data) {
    // Exclude the checkbox column from the data
    const filteredData = data.map(item => {
        const { checkbox,company_id,device_readings, ...rest } = item;
        // Remove HTML tags from the sample_name field and store the original value
        const originalSampleName = rest.sample_name;
        rest.sample_name = originalSampleName.replace(/<\/?[^>]+(>|$)/g, "");

        // Add "(force stopped)" to the sample_name if tags were removed
        if (originalSampleName !== rest.sample_name) {
            rest.sample_name += " (Stopped)";
        }
        return rest;
    });

    // Create worksheet from the filtered data
    const ws = XLSX.utils.json_to_sheet(filteredData);
    // Modify existing column names
    ws['A1'].v = 'Device ID';
    ws['B1'].v = 'Sample Name';
    ws['C1'].v = 'Date';
    ws['D1'].v = 'Decolorized Time';
    ws['E1'].v = 'Start Time';
    ws['F1'].v = 'End Time';
    ws['G1'].v = 'Channel ID';
    ws['H1'].v = 'End Progress';
    // Create workbook and append the worksheet
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Convert workbook data to base64
    const wbData = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });

    // Create a Blob from base64 data
    const blob = new Blob([s2ab(atob(wbData))], { type: 'application/octet-stream' });

    // Create a download link and trigger the click event
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'exported_data.xlsx';

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
}


function exportToExcel(data) {
    // Exclude the checkbox column from the data
    const filteredData = data.map(item => {
        const { checkbox, company_id, device_id, device_readings, ...rest } = item;

        // Remove HTML tags from the sample_name field and store the original value
        const originalSampleName = rest.sample_name;
        rest.sample_name = originalSampleName.replace(/<\/?[^>]+(>|$)/g, "");

        // Add "(force stopped)" to the sample_name if tags were removed
        if (originalSampleName !== rest.sample_name) {
            rest.sample_name += " (force stopped)";
        }

        return rest;
    });

    // Create worksheet from the filtered data
    const ws = XLSX.utils.json_to_sheet(filteredData);

    // Modify existing column names
    ws['A1'].v = 'Sample Name';
    ws['B1'].v = 'Date';
    ws['C1'].v = 'Decolorized Time';
    ws['D1'].v = 'Start Time';
    ws['E1'].v = 'End Time';
    ws['F1'].v = 'Channel ID';
    ws['G1'].v = 'End Progress';


    // Create workbook and append the worksheet
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Convert workbook data to base64
    const wbData = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });

    // Create a Blob from base64 data
    const blob = new Blob([s2ab(atob(wbData))], { type: 'application/octet-stream' });

    // Create a download link and trigger the click event
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'exported_data.xlsx';

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
}





function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}



function exportSelectedData(data) {
    // Filter data based on checked checkboxes
    const checkedRows = $('input[type="checkbox"]:checked').map(function() {
        return $(this).closest('tr').index(); 
    }).get();

    if (checkedRows.length === 0) {
        // Display a toast message if no rows are selected
        showToastUser("No rows selected..");
        return;
    }

    const filteredData = data.filter((_, index) => checkedRows.includes(index));

    const filteredDataWithoutCheckbox = filteredData.map(item => {
        const { checkbox, company_id, device_id, device_readings, ...rest } = item;
        // Remove HTML tags from the sample_name field and store the original value
        const originalSampleName = rest.sample_name;
        rest.sample_name = originalSampleName.replace(/<\/?[^>]+(>|$)/g, "");

        // Add "(force stopped)" to the sample_name if tags were removed
        if (originalSampleName !== rest.sample_name) {
            rest.sample_name += " (Stopped)";
        }
        return rest;
    });

    const ws = XLSX.utils.json_to_sheet(filteredDataWithoutCheckbox);
    // Modify existing column names
    ws['A1'].v = 'Sample Name';
    ws['B1'].v = 'Date';
    ws['C1'].v = 'Decolorized Time';
    ws['D1'].v = 'Start Time';
    ws['E1'].v = 'End Time';
    ws['F1'].v = 'Channel ID';
    ws['G1'].v = 'End Progress';
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    const wbData = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });

    const blob = new Blob([s2ab(atob(wbData))], { type: 'application/octet-stream' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'exported_data.xlsx';

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
}

function exportAdminSelectedData(data) {
    // Filter data based on checked checkboxes
    const checkedRows = $('input[type="checkbox"]:checked').map(function() {
        return $(this).closest('tr').index(); 
    }).get();

    // Check if any rows are selected
    if (checkedRows.length === 0) {
        // Display a toast message if no rows are selected
        showToast("No rows selected..");
        return;
    }

    const filteredData = data.filter((_, index) => checkedRows.includes(index));

    const filteredDataWithoutCheckbox = filteredData.map(item => {
        const { checkbox, device_id, device_readings, ...rest } = item;
         // Remove HTML tags from the sample_name field and store the original value
         const originalSampleName = rest.sample_name;
         rest.sample_name = originalSampleName.replace(/<\/?[^>]+(>|$)/g, "");
 
         // Add "(force stopped)" to the sample_name if tags were removed
         if (originalSampleName !== rest.sample_name) {
             rest.sample_name += " (Stopped)";
         }
        return rest;
    });

    const ws = XLSX.utils.json_to_sheet(filteredDataWithoutCheckbox);
    // Modify existing column names
    ws['A1'].v = 'Device ID';
    ws['B1'].v = 'Sample Name';
    ws['C1'].v = 'Date';
    ws['D1'].v = 'Decolorized Time';
    ws['E1'].v = 'Start Time';
    ws['F1'].v = 'End Time';
    ws['G1'].v = 'Channel ID';
    ws['H1'].v = 'End Progress';
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    const wbData = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });

    const blob = new Blob([s2ab(atob(wbData))], { type: 'application/octet-stream' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'exported_data.xlsx';

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
}


function showToast(message) {
    // Create a popover element
    const popover = $('<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>');

    // Set the popover content
    popover.find('.popover-header').text('');
    popover.find('.popover-body').text(message);

    // Get the position of the download button
    const buttonPosition = $('#adminDownload ').offset();

    // Display the popover just below the button
    popover.css({
        position: 'absolute',
        top: buttonPosition.top + $('#adminDownload').height() + 10,
        left: buttonPosition.left
    });

    // Append the popover to the body
    $('body').append(popover);

    // Hide the popover after 3 seconds
    setTimeout(() => {
        popover.remove();
    }, 3000);
}

function showToastUser(message) {
    // Create a popover element
    const popover = $('<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>');

    // Set the popover content
    popover.find('.popover-header').text('');
    popover.find('.popover-body').text(message);

    // Get the position of the download button
    const buttonPosition = $('#userDownload ').offset();

    // Display the popover just below the button
    popover.css({
        position: 'absolute',
        top: buttonPosition.top + $('#userDownload').height() + 10,
        left: buttonPosition.left
    });

    // Append the popover to the body
    $('body').append(popover);

    // Hide the popover after 3 seconds
    setTimeout(() => {
        popover.remove();
    }, 3000);
}

