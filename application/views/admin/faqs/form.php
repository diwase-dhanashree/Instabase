<div class="box box-primary">
    <div class="box-body">
        <?= form_open() ?>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="question" class="required">Question</label>
                    <textarea id="question" name="question" class="form-control" required><?= isset($row['question']) ? $row['question'] : "" ?></textarea>
                </div>

                <div class="form-group col-sm-12">
                    <label for="answer" class="required">Answer</label>
                    <textarea id="answer" name="answer" class="form-control editor" required><?= isset($row['answer']) ? $row['answer'] : "" ?></textarea>
                </div>

                <div class="form-group col-sm-4">
                    <label for="status" class="required">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" <?= isset($row['status']) && $row['status'] ? 'selected' : "" ?>>Active</option>
                        <option value="0" <?= isset($row['status']) && !$row['status'] ? 'selected' : "" ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label for="sort_order" >Sort Order</label>
                    <input type="text" id="sort_order" name="sort_order" class="form-control numberonly" value="<?= isset($row['sort_order']) ? $row['sort_order'] : "" ?>"  />
                </div>

                <div class="form-group col-sm-12">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button> 
                    <a href="<?= admin_url('faqs') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>