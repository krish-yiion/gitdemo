<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Responsive Design with Scrollable, Sticky, and Editable Table</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .scrollable-table {
      max-height: 200px; /* Adjust the max height as needed */
      overflow-y: auto;
      position: relative;
    }
    .scrollable-table thead th {
      position: sticky;
      top: 0;
      background: white; /* Ensure the background matches the table */
      z-index: 1;
    }
    .drag-over {
      background-color: #f0f0f0;
    }
    .action-buttons {
      display: flex;
      gap: 5px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="p-3 border bg-light">
        <div class="scrollable-table">
          <table class="table" id="table1">
            <thead>
              <tr>
                <th>Column 1 Table</th>
              </tr>
            </thead>
            <tbody>
              <tr draggable="true" ondragstart="drag(event)">
                <td>Data 1</td>
              </tr>
              <tr draggable="true" ondragstart="drag(event)">
                <td>Data 2</td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="p-3 border bg-light">
        <div class="scrollable-table" id="table2-container" ondrop="drop(event)" ondragover="allowDrop(event)">
          <table class="table" id="table2">
            <thead>
              <tr>
                <th>Column 2 Table</th>
              </tr>
            </thead>
            <tbody>
              <tr draggable="true" ondragstart="drag(event)">
                <td>
                  Data 1
                  <div class="action-buttons">
                    <button onclick="removeRow(this)">Remove</button>
                    <button onclick="duplicateRow(this)">Duplicate</button>
                  </div>
                </td>
              </tr>
              <tr draggable="true" ondragstart="drag(event)">
                <td>
                  Data 2
                  <div class="action-buttons">
                    <button onclick="removeRow(this)">Remove</button>
                    <button onclick="duplicateRow(this)">Duplicate</button>
                  </div>
                </td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="p-3 border bg-light">
        <div class="scrollable-table">
          <table class="table">
            <thead>
              <tr>
                <th>Full Width Table</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Data 1</td>
              </tr>
              <tr>
                <td>Data 2</td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  let draggedRow = null;

  function allowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.add('drag-over');
  }

  function drag(ev) {
    draggedRow = ev.target;
  }

  function drop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.remove('drag-over');
    if (draggedRow) {
      // Check if the dragged row is from table1
      let isFromTable1 = draggedRow.closest('#table1') !== null;

      // Clone the dragged row if it's from table1
      let rowToAppend = isFromTable1 ? draggedRow.cloneNode(true) : draggedRow;

      // Add action buttons to the new row if it does not have them
      if (!rowToAppend.querySelector('.action-buttons')) {
        addActionButtons(rowToAppend);
      }

      // Append the (cloned or moved) row to the target table body
      let targetTable = ev.currentTarget.querySelector('tbody');
      targetTable.appendChild(rowToAppend);

      // Make the new row draggable
      rowToAppend.setAttribute('draggable', 'true');
      rowToAppend.setAttribute('ondragstart', 'drag(event)');

      // Reset the draggedRow
      draggedRow = null;
    }
  }

  function removeRow(button) {
    button.closest('tr').remove();
  }

  function duplicateRow(button) {
    var row = button.closest('tr');
    var clone = row.cloneNode(true);
    row.parentNode.insertBefore(clone, row.nextSibling);
    updateActionButtons();
  }

  function addActionButtons(row) {
    var actionButtons = document.createElement('div');
    actionButtons.className = 'action-buttons';
    actionButtons.innerHTML = '<button onclick="removeRow(this)">Remove</button> <button onclick="duplicateRow(this)">Duplicate</button>';
    row.querySelector('td').appendChild(actionButtons);
  }

  // Update action buttons and draggable attributes on page load and after row operations
  function updateActionButtons() {
    document.querySelectorAll('#table2 tbody tr').forEach(row => {
      if (!row.querySelector('.action-buttons')) {
        addActionButtons(row);
      }
      row.setAttribute('draggable', 'true');
      row.setAttribute('ondragstart', 'drag(event)');
    });
  }

  // Update action buttons on page load
  document.addEventListener('DOMContentLoaded', updateActionButtons);
</script>
</body>
</html>
