<style>
  /* Modal background overlay */
.modal.fade .modal-dialog {
  transform: translateY(-50px);
  transition: transform 0.3s ease-out;
}

.modal.fade.show .modal-dialog {
  transform: translateY(0);
}

/* Modal content styling */
#confirmCancelModal .modal-content {
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  border: none;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Modal header */
#confirmCancelModal .modal-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  padding: 1rem 1.5rem;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}

#confirmCancelModal .modal-title {
  font-weight: 600;
  font-size: 1.25rem;
  color: #333;
}

/* Close button */
#confirmCancelModal .btn-close {
  filter: brightness(0.6);
  transition: filter 0.2s ease;
}

#confirmCancelModal .btn-close:hover {
  filter: brightness(1);
}

/* Modal body */
#confirmCancelModal .modal-body {
  font-size: 1rem;
  color: #555;
  padding: 1.5rem 1.5rem;
  text-align: center;
}

/* Modal footer */
#confirmCancelModal .modal-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #dee2e6;
  justify-content: center;
  gap: 1rem;
}

/* Buttons */
#confirmCancelModal .btn-secondary {
  background-color: #6c757d;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 8px;
  font-weight: 500;
  transition: background-color 0.3s ease;
}

#confirmCancelModal .btn-secondary:hover {
  background-color: #5a6268;
}

#confirmCancelModal .btn-danger {
  background-color: #ff8210;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

#confirmCancelModal .btn-danger:hover {
  background-color: #c82333;
}

</style>
<div class="modal fade" id="confirmCancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this booking?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>
