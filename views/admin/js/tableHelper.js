function initializeGenericPagination(containerSelector = ".inline-flex.rounded-button.shadow-sm") {
    const paginationButtonsContainer = document.querySelector(containerSelector);

    if (!paginationButtonsContainer) {
        return; 
    }

    const paginationButtons = Array.from(paginationButtonsContainer.querySelectorAll(".pagination-btn"));
    const nextPageButton = paginationButtonsContainer.querySelector(".ri-arrow-right-s-line")?.parentElement;
    const prevPageButton = paginationButtonsContainer.querySelector(".ri-arrow-left-s-line")?.parentElement;

    if (paginationButtons.length === 0 || !prevPageButton || !nextPageButton) {
        return;
    }

    let currentPage = 1;
    const totalNumberedPages = paginationButtons.length;

    function updatePaginationUI(newPage) {
        currentPage = newPage;

        paginationButtons.forEach((btn) => {
            const pageNumberOfButton = parseInt(btn.textContent);
            if (pageNumberOfButton === currentPage) {
                btn.classList.remove("bg-gray-700", "text-gray-300", "hover:bg-gray-600");
                btn.classList.add("bg-secondary", "text-primary");
            } else {
                btn.classList.remove("bg-secondary", "text-primary");
                btn.classList.add("bg-gray-700", "text-gray-300", "hover:bg-gray-600");
            }
        });

        prevPageButton.disabled = (currentPage === 1);
        nextPageButton.disabled = (currentPage === totalNumberedPages);
    }

    if (nextPageButton) {
        nextPageButton.addEventListener("click", () => {
            if (!nextPageButton.disabled && currentPage < totalNumberedPages) {
                updatePaginationUI(currentPage + 1);
                // Di sini Anda biasanya akan memicu pembaruan data tabel
            }
        });
    }

    if (prevPageButton) {
        prevPageButton.addEventListener("click", () => {
            if (!prevPageButton.disabled && currentPage > 1) {
                updatePaginationUI(currentPage - 1);
                // Di sini Anda biasanya akan memicu pembaruan data tabel
            }
        });
    }

    paginationButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const pageNumber = parseInt(btn.textContent);
            if (!isNaN(pageNumber)) {
                updatePaginationUI(pageNumber);
                // Di sini Anda biasanya akan memicu pembaruan data tabel
            }
        });
    });

    let initialPage = 1;
    const activeButton = paginationButtons.find(btn => btn.classList.contains('bg-secondary') && btn.classList.contains('text-primary'));
    if (activeButton) {
        const pageNum = parseInt(activeButton.textContent);
        if (!isNaN(pageNum)) {
            initialPage = pageNum;
        }
    }
    updatePaginationUI(initialPage);
}