<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  .modal-dialog {
    max-width: 600px;
    width: 90%;
    margin: 1.75rem auto;
  }

  .modal-content {
    position: relative;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    border: none;
    font-family: 'Poppins', sans-serif;
    background-color: rgba(40, 40, 40, 0.7); 
    color: #ecedea;
    overflow: hidden;
  }

  .modal-header {
    position: relative;  
    color: rgb(255, 255, 255);
    border-bottom: 3px solid #ecedea;
    border-top-left-radius: 15px;
    border-top-right-radius: 12px;
    padding: 0.75rem 1rem;
    font-weight: 700;
    font-size: 1.5rem;
    background-color: transparent; 
    overflow: hidden;
  }

  .modal-header::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    opacity: 0.2;
    border-top-left-radius: 15px;
    border-top-right-radius: 12px;
    z-index: 0;
    pointer-events: none;
  }

  .modal-header > * {
    position: relative;
    z-index: 1;
  }

  .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.2s ease;
  }

  .btn-close:hover {
    opacity: 1;
  }

  .modal-body {
    padding: 1.25rem;
    font-size: 1rem;
    color: #282828;
    background-color: rgb(239, 175, 111);
    word-wrap: break-word;
  }

  .form-label {
    font-weight: 600;
    color: #282828;
  }

  .form-control[type="file"] {
    border-radius: 6px;
    border: 1px solid #282828;
    padding: 0.4rem 0.75rem;
    font-size: 0.95rem;
    cursor: pointer;
    transition: border-color 0.2s ease;
    background-color: #ecedea;
    color: #282828;
  }

  .form-control[type="file"]:focus {
    outline: none;
    border-color: #ff8210;
    box-shadow: 0 0 5px rgba(255,130,16,0.5);
  }

  .form-text {
    font-size: 0.85rem;
    color: #282828;
    margin-top: 0.25rem;
  }

  .modal-footer {
    background-color: #efae6f;
    padding: 1rem;
    border-top: none;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 0.75rem;
  }

  .btn-primary {
    background-color: #f69432;
    border: none;
    padding: 0.5rem 1.25rem;
    font-weight: 700;
    border-radius: 6px;
    color: rgb(13, 14, 13);
    transition: background-color 0.3s ease;
    box-shadow: 0 3px 8px rgba(255,130,16,0.6);
  }

  .btn-primary:hover {
    background-color: #f69432;
    box-shadow: 0 4px 12px rgba(202, 130, 58, 0.7);
  }

  .btn-secondary {
    background-color: #282828;
    border: none;
    padding: 0.5rem 1.25rem;
    font-weight: 700;
    border-radius: 6px;
    color: rgb(255, 255, 255);
    transition: background-color 0.3s ease;
    box-shadow: 0 3px 8px rgba(40,40,40,0.6);
  }

  .btn-secondary:hover {
    background-color: #3b3b3b;
  }

  @media (max-width: 576px) {
    .modal-header {
      font-size: 1.3rem;
      padding: 0.5rem 0.75rem;
    }

    .modal-body {
      padding: 1rem;
      font-size: 0.95rem;
    }

    .modal-footer {
      flex-direction: column;
      align-items: stretch;
    }

    .modal-footer .btn {
      width: 100%;
    }
  }
</style>

<!-- Modal -->
<div class="modal fade" id="verifyDocumentsModal" tabindex="-1" aria-labelledby="verifyDocumentsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data" action="../utils/submit-documents.php">
        <div class="modal-header">
          <h5 class="modal-title" id="verifyDocumentsModalLabel">Submit Verification Documents</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted">Please upload the required documents for verification. Any valid ID</p>

          <div class="mb-3">
            <label for="documentFiles" class="form-label">Upload Document(s)</label>
            <input class="form-control" type="file" name="documents[]" id="documentFiles" multiple required accept=".pdf,.jpg,.jpeg,.png">
            <div class="form-text">You can upload multiple files (PDF, JPEG, JPG, PNG).</div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="submit-documents" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
