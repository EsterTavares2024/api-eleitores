<footer class="main-footer text-center">
  © <?= date('Y') ?> Direitos Reservados
</footer>
</div> <!-- fecha .wrapper -->

<!-- Scripts principais -->
<script src="../../assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="../../assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/AdminLTE/dist/js/adminlte.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['error'])): ?>
  <script>
    <?php $error = htmlspecialchars($_GET['error']); ?>

    // 🎯 SweetAlerts baseados no tipo de erro
    <?php if ($error === 'cpf'): ?>
      Swal.fire({
        icon: 'error',
        title: 'CPF já cadastrado',
        text: 'Já existe um eleitor com este CPF.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'invalidcpf'): ?>
      Swal.fire({
        icon: 'error',
        title: 'CPF inválido',
        text: 'Por favor, insira um CPF válido.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'notfound'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Erro ao excluir',
        text: 'Registro não encontrado ou você não tem permissão.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'all'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Exclusão bloqueada',
        text: 'Você não pode excluir todos os candidatos com eleitores vinculados.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'linked'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Ação bloqueada',
        text: 'Não é possível excluir. Existem eleitores vinculados.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'empty'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Campos obrigatórios',
        text: 'Você precisa preencher todos os campos.',
        confirmButtonColor: '#d33'
      });

    <?php elseif ($error === 'duplicate'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Nome duplicado',
        text: 'Já existe um candidato com esse nome.',
        confirmButtonColor: '#d33'
      });
    <?php endif; ?>
  </script>
<?php endif; ?>

<!-- Sucesso -->
<?php if (isset($_GET['success'])): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Sucesso!',
      text: 'Ação realizada com sucesso.',
      confirmButtonColor: '#28a745'
    });
  </script>
<?php endif; ?>

<!-- 🔒 Funções globais de confirmação -->
<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Tem certeza?',
      text: 'Esta ação não poderá ser desfeita.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sim, excluir',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'action/delete.php?id=' + id;
      }
    });
  }

  function confirmDeleteAll() {
    Swal.fire({
      title: 'Excluir todos os candidatos?',
      text: 'Essa ação é irreversível e pode afetar dados vinculados.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sim, excluir todos',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'action/delete_all.php';
      }
    });
  }
</script>

</body>
</html>
