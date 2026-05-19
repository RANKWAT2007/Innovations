<div class="card card-custom p-4">

    <div class="chat-box mb-3" style="height:350px;overflow-y:auto;">

        <?php foreach($messages as $msg): ?>

            <div class="mb-3">

                <strong>
                    User <?= $msg['sender_id'] ?>
                </strong>

                <p>
                    <?= $msg['message'] ?>
                </p>

            </div>

        <?php endforeach; ?>

    </div>

    <form method="POST">

        <div class="input-group">

            <input
                type="text"
                name="message"
                class="form-control"
                placeholder="Type message..."
                required
            >

            <button class="btn btn-teal">
                Send
            </button>

        </div>

    </form>

</div>