
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<!-- <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="pdf_file">
    <button type="submit">Upload PDF</button>
</form></br></br> -->
</br>
<form action="{{ route('checkStringInPdf') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="pdf_file">Upload PDF file:</label>
        <input type="file" name="pdf_file" accept=".pdf" required>
        <br><br>
        <label for="search_string">Enter search string:</label>
        <input type="text" name="search_string" required>
        <br><br>
        <button type="submit">Check String</button>
</form>