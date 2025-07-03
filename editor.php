<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editor HTML em Tempo Real</title>
  <link rel="icon" href="/logo.png">
  <style>
    :root {
      --bg-color: #def;
      --text-color: #000;
      --border-color: #ccc;
      --editor-bg: #fff;
    }

    body.dark {
      --bg-color: #121212;
      --text-color: #eee;
      --border-color: #444;
      --editor-bg: #1e1e1e;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
    }

    .container {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .toolbar {
      display: flex;
      gap: 10px;
      padding: 10px;
      background: var(--bg-color);
      border-bottom: 1px solid var(--border-color);
    }

    .toolbar button {
      padding: 6px 12px;
      cursor: pointer;
      background: var(--editor-bg);
      border: 1px solid var(--border-color);
      color: var(--text-color);
    }

    .editor {
      flex: 1;
      padding: 10px;
      background-color: var(--bg-color);
    }

    textarea {
      width: 100%;
      height: 100%;
      font-family: monospace;
      font-size: 16px;
      resize: none;
      border: 1px solid var(--border-color);
      padding: 10px;
      background: var(--editor-bg);
      color: var(--text-color);
    }

    .preview {
      flex: 1;
      border-top: 2px solid var(--border-color);
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
      background: white;
    }
  </style>
</head>
<body>

  <div class="container">
    
    <!-- Barra de ferramentas -->
    <div class="toolbar">
      <button onclick="clearEditor()">🧹 Limpar</button>
      <button onclick="copyToClipboard()">📋 Copiar</button>
      <button onclick="downloadHTML()">💾 Baixar</button>
      <button onclick="toggleTheme()">🌗 Tema Claro/Escuro</button>
    </div>

    <!-- Área de edição -->
    <div class="editor">
      <textarea id="editor"></textarea>
    </div>

    <!-- Área de visualização -->
    <div class="preview">
      <iframe id="preview"></iframe>
    </div>
  </div>

  <script>
    const editor = document.getElementById('editor');
    const previewFrame = document.getElementById('preview');

    const defaultContent = `
<h3>Bem-vindo ao editor HTML em tempo real!</h3>
<p>Digite HTML na área de texto acima e ele aparecerá magicamente no quadro abaixo.</p>
`;

    const credits = `
<div style="position:absolute; bottom:0.5em; right:0.5em; font-size:small;">
  Criado por <a href="https://www.asasdev.com.br/" target="_blank">Alysson Almeida</a> e hospedado por 
  <a href="https://www.valuehost.com.br/cliente/aff.php?aff=1674" target="_blank">ValueHost</a>.
</div>
`;

    // Carrega o conteúdo salvo ou o padrão
    function loadEditorContent() {
      const saved = localStorage.getItem('htmlEditorContent');
      editor.value = saved || defaultContent;
      updatePreview();
    }

    // Atualiza o iframe de visualização
    function updatePreview() {
      const content = editor.value;
      const doc = previewFrame.contentDocument || previewFrame.contentWindow.document;
      doc.open();
      doc.write(content);

      if (content.replace(/\s/g, '') === defaultContent.replace(/\s/g, '')) {
        doc.write(credits);
      }

      doc.close();

      // Salva automaticamente no localStorage
      localStorage.setItem('htmlEditorContent', content);
    }

    // Botão: limpar editor
    function clearEditor() {
      if (confirm("Deseja realmente limpar o conteúdo?")) {
        editor.value = '';
        updatePreview();
      }
    }

    // Botão: copiar conteúdo
    function copyToClipboard() {
      navigator.clipboard.writeText(editor.value).then(() => {
        alert('Conteúdo copiado para a área de transferência!');
      });
    }

    // Botão: baixar HTML
    function downloadHTML() {
      const blob = new Blob([editor.value], { type: 'text/html' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'meu-html.html';
      a.click();
      URL.revokeObjectURL(url);
    }

    // Botão: alternar tema
    function toggleTheme() {
      document.body.classList.toggle('dark');
    }

    // Eventos
    editor.addEventListener('input', updatePreview);
    window.addEventListener('DOMContentLoaded', loadEditorContent);
  </script>

</body>
</html>
