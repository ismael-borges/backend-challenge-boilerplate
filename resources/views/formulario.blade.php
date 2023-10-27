<!DOCTYPE html>
<html>
<head>
    <title>Upload de Arquivos</title>
</head>
<body>
<h2>Formulário de Upload de Arquivos</h2>

<form action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Enviar Arquivo</button>
</form>
</body>
</html>
