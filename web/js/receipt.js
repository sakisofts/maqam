/**
 * JavaScript for Receipt widget
 */

// This function is registered inline by the widget itself
// function printReceipt(id) {
//     var printContents = document.getElementById(id).innerHTML;
//     var originalContents = document.body.innerHTML;
//
//     document.body.innerHTML = '<div class="receipt-print-container">' + printContents + '</div>';
//
//     window.print();
//
//     document.body.innerHTML = originalContents;
// }

// Additional functions for receipt handling can be added here
// document.addEventListener('DOMContentLoaded', function() {
//     // Add any initialization code here
//
//     // Handle paper size changes if needed
//     var paperSizeSelectors = document.querySelectorAll('.paper-size-selector');
//     if (paperSizeSelectors.length) {
//         paperSizeSelectors.forEach(function(selector) {
//             selector.addEventListener('change', function(e) {
//                 var receiptId = this.getAttribute('data-receipt-id');
//                 var receipt = document.getElementById(receiptId);
//                 // Remove existing paper size classes
//                 receipt.classList.remove('paper-80mm', 'paper-a4', 'paper-letter');
//                 // Add new paper size class
//                 receipt.classList.add('paper-' + this.value);
//             });
//         });
//     }
// });
