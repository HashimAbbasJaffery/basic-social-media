class Post extends HTMLElement {
    // static observedAttributes = ['foo'];

    constructor() {
        super();
        this.by = "";
        this.at = "";
        this.details = "";
        this.image = "";
        this.comments = "";
        this.identify = "";
        this.likes = "";
        this.render();
    }
    static get observedAttributes() {
        return ["by", "at", "details", "image", "comments", "likes", "identify"];
    }
    attributeChangedCallback(name, oldVal, newVal) {
        this[name] = newVal;
        this.render();
    }
    #writerGenerator(name, comment, id) {
        return `
        <div class="comment-writer">
            <p>${name}</p>
        </div>
        <div class="comment-material">
            <p>${comment}
                <span class="reply" id="${id}">Reply</span>
            </p>
        </div>`;
    }
    #generateReplies(name, reply) {
        return `
            <div class="replies">
                <div class="comment-writer">
                    <p>${name}</p>
                </div>
                <div class="comment-material reply">
                    <p>${reply}</p>
                </div>
            </div>
        `
    }
    #generateComments(id) {
        let comments = [];
        let html = "";
        try {
            console.log(...JSON.parse(this.comments));
            comments = [...JSON.parse(this.comments)];
            comments.forEach(comment => {
                html += this.#writerGenerator(comment.name, comment.comment, id);
                if (comment.replies) {
                    const replies = comment.replies;
                    replies.forEach(reply => {
                        html += this.#generateReplies(reply.name, reply.comment);
                    })
                }
            })
            // console.log(html);
        } catch (e) { }
        return html;
    }
    #generateImage(image) {
        let html = "";
        if(this.image != "null") {
            html = `<div class="post-image" style="background-image: url(${this.image
            });">
                &nbsp;
            </div>`
        }
        return html;
    }
    render() {
        this.innerHTML = `
        <div class="post">
            <div class="user-details">
                <p>Uploaded by: ${this.by}</p>
                <p>Uploaded at: ${this.at}</p>
            </div>
            <div class="post-details">
                <p>${this.details}</p>
                ${this.#generateImage(this.image)}
            </div>
            <div class="post-btn">
                <button>Share</button>
                <button>Like</button>
                <button>Comment</button>
            </div>
            <div class="additional-details">
                <p class="likes" id="${this.identify}">${this.likes} Likes</p>
                <p class="show-comments" id="${this.identify}">${1} Comments</p>

            </div>
            <div class="comment none" id="${this.identify}">
                ${this.#generateComments(this.identify)}
                <div class="add-comment" id="${this.identify}">
                    <input type="text" name="comment" placeholder="Comment">
                </div>
            </div>
            <div class="liked-persons" id="${this.identify}">
                <ul>
                    <li>hashim</li>
                    <li>tanzeela</li>
                    <li>taskeen</li>
                </ul>
            </div>
        </div>
    `;
    }
}
customElements.define("app-post", Post);
