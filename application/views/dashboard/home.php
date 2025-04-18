<style>
.card_app {
    width: 252px;
    height: 265px;
    background: white;
    border-radius: 30px;
    box-shadow: 15px 15px 30px #bebebe,
        -15px -15px 30px #ffffff;
    transition: 0.2s ease-in-out;
}

.img_app {
    width: 100%;
    height: 50%;
    border-top-left-radius: 30px;
    border-top-right-radius: 30px;
    background: linear-gradient(#e66465, #9198e5);
    display: flex;
    align-items: top;
    justify-content: right;
}

.text_app {
    margin: 20px;
    display: flex;
    flex-direction: column;
    align-items: space-around;
}

.text_app .h3 {
    font-family: 'Lucida Sans'sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: black;
}

.text_app p {
    font-family: 'Lucida Sans'sans-serif;
    color: #999999;
    font-size: 13px;
}

.card_app:hover {
    cursor: pointer;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.save_app:hover {
    transform: scale(1.1) rotate(10deg);
}

.save_app:hover .svg {
    fill: #ced8de;
}
</style>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-start align-content-start" id="list-app">



        </div>
    </div>
</div>