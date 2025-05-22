<div class="container main-content">
    <main>
        <h1 class="title">¡Añade tus Productos!</h1>
        <p class="subtitle">Personaliza tu lista de compras fácilmente</p>

        <div class="welcome-message">
            <div class="message-icon">
                <i class="bi bi-heart-fill"></i>
            </div>
            <p>
                Queremos hacer tu día a día más sencillo.
                <span class="text-highlight">Añade los productos que necesitas</span>
                y organízalos por categorías para que tus compras sean más eficientes.
                ¡Tu tiempo es valioso!
            </p>
        </div>

        <div class="row mt-4">
            <div class="col-lg-7 mx-auto">
                <div class="form-card">
                    <div class="form-header">
                        <i class="bi bi-basket-fill"></i>
                        <h4>Datos del Producto</h4>
                    </div>

                    <form id="formProducto" method="POST" action="/productos/guardar">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Papel higiénico" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="1" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-bookmarks"></i></span>
                                    <select class="form-select" id="id_categoria" name="id_categoria" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach($categorias as $cat): ?>
                                            <option value="<?= $cat->id_categoria ?>"><?= $cat->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="id_prioridad" class="form-label">Prioridad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-star"></i></span>
                                    <select class="form-select" id="id_prioridad" name="id_prioridad" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach($prioridades as $p): ?>
                                            <option value="<?= $p->id_prioridad ?>"><?= $p->nivel ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="notas_adicionales" class="form-label">Notas Adicionales (opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <textarea class="form-control" id="notas_adicionales" name="notas_adicionales" rows="2" placeholder="Alguna especificación o detalle importante"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons mt-4 d-flex justify-content-between">
                            <a href="/app01_mrml" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>


<script src="<?= asset('build/js/productos/index.js') ?>"></script>