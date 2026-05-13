  const title = document.getElementById("article-title")
  const floating = document.getElementById("floating-title")
  const aside = document.getElementById("aside")

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry.isIntersecting) {
        floating.classList.remove("opacity-0", "translate-y-2")
        floating.classList.add("opacity-100", "translate-y-0")
        aside.classList.add("pt-8")
      } else {
        floating.classList.add("opacity-0", "translate-y-2")
        floating.classList.remove("opacity-100", "translate-y-0")
        aside.classList.remove("pt-8")
      }
    },
    {
      threshold: 0
    }
  )

  observer.observe(title)