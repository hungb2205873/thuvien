// Mobile menu toggle
const menuToggle = document.getElementById("menuToggle")
const navMenu = document.getElementById("navMenu")

if (menuToggle) {
  menuToggle.addEventListener("click", () => {
    navMenu.classList.toggle("active")
  })
}

// Close menu when link clicked
const navLinks = document.querySelectorAll(".nav-menu a")
navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    navMenu.classList.remove("active")
  })
})

// Load books data
const mockBooks = [
  {
    id: 1,
    title: "Đắc Nhân Tâm",
    author: "Dale Carnegie",
    description: "Cuốn sách kinh điển về kỹ năng giao tiếp và xây dựng mối quan hệ.",
    category: "Tâm Lý",
    updated_at: "2024-01-15",
    rating: 4.8,
  },
  {
    id: 2,
    title: "Tư Duy Nhanh và Chậm",
    author: "Daniel Kahneman",
    description: "Khám phá cách não bộ đưa ra quyết định và rơi vào các sai lầm nhận thức.",
    category: "Tâm Lý",
    updated_at: "2024-01-20",
    rating: 4.7,
  },
  {
    id: 3,
    title: "Dạy Con Làm Giàu",
    author: "Robert T. Kiyosaki",
    description: "Hướng dẫn cha mẹ dạy con về tiền bạc và tạo dựng tài chính lành mạnh.",
    category: "Kinh Doanh",
    updated_at: "2024-01-25",
    rating: 4.6,
  },
]

// Render books
function renderBooks() {
  const booksContainer = document.getElementById("booksContainer")

  if (booksContainer) {
    booksContainer.innerHTML = mockBooks
      .map(
        (book) => `
      <div class="book-card">
        <div class="book-cover">📚</div>
        <div class="book-info">
          <div class="book-title">${book.title}</div>
          <div class="book-author">Tác giả: ${book.author}</div>
          <div class="book-description">${book.description}</div>
          <div class="book-meta">
            <span>${book.category}</span>
            <span class="book-rating">⭐ ${book.rating}</span>
          </div>
          <a href="login.html" class="btn btn-primary" style="display: block; text-align: center;">Mượn Sách</a>
        </div>
      </div>
    `,
      )
      .join("")
  }
}

function searchFromHero() {
  const searchInput = document.getElementById("heroSearchInput")
  if (searchInput) {
    const query = searchInput.value.trim()
    if (query) {
      // Store search query in sessionStorage to pass to library page
      sessionStorage.setItem("searchQuery", query)
      window.location.href = "library.html"
    }
  }
}

// Allow search on Enter key in hero search
document.addEventListener("DOMContentLoaded", () => {
  const heroSearchInput = document.getElementById("heroSearchInput")
  if (heroSearchInput) {
    heroSearchInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        searchFromHero()
      }
    })
  }
  renderBooks()
})
