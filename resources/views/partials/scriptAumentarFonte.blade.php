<script>
    document.addEventListener("DOMContentLoaded", function () {
      const body = document.body;
      const fontSizeButton = document.getElementById('font-size-btn');
      const fontSizeIcon = document.getElementById('font-size-icon');

      // Função para atualizar o tamanho da fonte e salvar no localStorage
      function updateFontSize() {
        // Verifica o tamanho da fonte no localStorage e aplica
        const isLargeFont = localStorage.getItem('large-font') === 'true';

        // Alterna entre o tamanho padrão e o tamanho grande
        if (isLargeFont) {
          body.classList.add('font-large');
          fontSizeIcon.classList.replace("bi-zoom-in", "bi-zoom-out"); // Troca o ícone para "zoom out"
        } else {
          body.classList.remove('font-large');
          fontSizeIcon.classList.replace("bi-zoom-out", "bi-zoom-in"); // Troca o ícone para "zoom in"
        }
      }

      // Inicializa o tamanho da fonte e o ícone ao carregar a página
      updateFontSize();

      // Event listener para o botão de aumentar/diminuir fonte
      fontSizeButton.addEventListener('click', function() {
        const isLargeFont = body.classList.contains('font-large');

        // Alterna a classe e salva a preferência no localStorage
        if (isLargeFont) {
          localStorage.setItem('large-font', 'false');
        } else {
          localStorage.setItem('large-font', 'true');
        }

        // Atualiza o estilo da página com base na preferência
        updateFontSize();
      });
    });
</script>
