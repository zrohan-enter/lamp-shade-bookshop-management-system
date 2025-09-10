import os
import requests

books_to_download = [
    {
        'title': 'Introduction to Algorithms',
        'filename': 'introduction_to_algorithms.jpg',
        'image_url': 'https://img.drz.lazcdn.com/g/kf/Sab08d3d709e246c4b7bf8e7a55c60ea9S.jpg_720x720q80.jpg'  # Paste the URL here
    },
    {
        'title': 'The Elements of Style',
        'filename': 'the_elements_of_style.jpg',
        'image_url': 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTyskbeE3zMo6yOYmIXwVFFBBS6yKLbsxR5mg&s'  # Paste the URL here
    },
    {
        'title': 'Calculus: Early Transcendentals',
        'filename': 'calculus_early_transcendentals.jpg',
        'image_url': 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlaZHGdrXgLrvzO7hwB6GOl7vNH431Cd1SMw&s'  # Paste the URL here
    },
    {
        'title': 'Organic Chemistry',
        'filename': 'organic_chemistry.jpg',
        'image_url': 'https://images.booksense.com/images/526/442/9781727442526.jpg'  # Paste the URL here
    },
    {
        'title': 'Principles of Economics',
        'filename': 'principles_of_economics.jpg',
        'image_url': 'https://ds.rokomari.store/rokomari110/ProductNew20190903/260X372/Principles_of_Economics-N_Gregory_Mankiw-6f4e4-378487.jpg'  # Paste the URL here
    },
    {
        'title': 'Moby Dick',
        'filename': 'moby_dick.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/91xNmlf86yL.jpg'  # Paste the URL here
    },
    {
        'title': 'The Great Gatsby',
        'filename': 'the_great_gatsby.jpg',
        'image_url': 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1738790966i/4671.jpg'  # Paste the URL here
    },
    {
        'title': 'War and Peace',
        'filename': 'war_and_peace.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/91teiIZ5vwL._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'Crime and Punishment',
        'filename': 'crime_and_punishment.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/71O2XIytdqL._UF894,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'The Odyssey',
        'filename': 'the_odyssey.jpg',
        'image_url': 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781451674187/the-odyssey-9781451674187_hr.jpg'  # Paste the URL here
    },
    {
        'title': 'Dune',
        'filename': 'dune.jpg',
        'image_url': 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com%2FDune-Deluxe-Frank-Herbert%2Fdp%2F059309932X&psig=AOvVaw3hoZRiCjP6644-1RDKw9gF&ust=1755459995180000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPismp2MkI8DFQAAAAAdAAAAABAE'  # Paste the URL here
    },
    {
        'title': 'The Martian',
        'filename': 'the_martian.jpg',
        'image_url': 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com%2FMartin-Complete-Various%2Fdp%2FB01N96LJIQ&psig=AOvVaw3O2LKSMll4040cUVwtQ4qF&ust=1755460029975000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCLC_v62MkI8DFQAAAAAdAAAAABAE'  # Paste the URL here
    },
    {
        'title': 'Ready Player One',
        'filename': 'ready_player_one.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/714qeTmyeyL._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'Project Hail Mary',
        'filename': 'project_hail_mary.jpg',
        'image_url': 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT118Q7nnEkSXPocOF79p2SpirZCFvv4Rbpaw&s'  # Paste the URL here
    },
    {
        'title': 'The Alchemist',
        'filename': 'the_alchemist.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/81UGPuNl7kL._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'The Lord of the Rings',
        'filename': 'the_lord_of_the_rings.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/7125+5E40JL._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'Harry Potter and the Sorcerer\'s Stone',
        'filename': 'harry_potter_and_the_sorcerers_stone.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/71XqqKTZz7L._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'A Game of Thrones',
        'filename': 'a_game_of_thrones.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/81d1Rl84ccL._UF1000,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'The Chronicles of Narnia',
        'filename': 'the_chronicles_of_narnia.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/81IsNyKSOmL.jpg'  # Paste the URL here
    },
    {
        'title': 'The Hitchhiker\'s Guide to the Galaxy',
        'filename': 'the_hitchhikers_guide_to_the_galaxy.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Death of a Salesman',
        'filename': 'death_of_a_salesman.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Hamlet',
        'filename': 'hamlet.jpg',
        'image_url': 'https://m.media-amazon.com/images/I/71B194DKnhL._UF894,1000_QL80_.jpg'  # Paste the URL here
    },
    {
        'title': 'A Streetcar Named Desire',
        'filename': 'a_streetcar_named_desire.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Waiting for Godot',
        'filename': 'waiting_for_godot.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Importance of Being Earnest',
        'filename': 'the_importance_of_being_earnest.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Girl with the Dragon Tattoo',
        'filename': 'the_girl_with_the_dragon_tattoo.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Gone Girl',
        'filename': 'gone_girl.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Silent Patient',
        'filename': 'the_silent_patient.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Da Vinci Code',
        'filename': 'the_da_vinci_code.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Prisoner of Azkaban',
        'filename': 'the_prisoner_of_azkaban.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Nightingale',
        'filename': 'the_nightingale.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Where the Crawdads Sing',
        'filename': 'where_the_crawdads_sing.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'The Midnight Library',
        'filename': 'the_midnight_library.jpg',
        'image_url': ''  # Paste the URL here
    },
    {
        'title': 'Educated',
        'filename': 'educated.jpg',
        'image_url': ''  # Paste the URL here
    }
]

# Create an 'images' directory if it doesn't exist
if not os.path.exists('images'):
    os.makedirs('images')

# Loop through the list and download images
for book in books_to_download:
    title = book['title']
    filename = book['filename']
    image_url = book['image_url']

    if image_url:
        try:
            print(f'Searching for cover for: {title}')
            response = requests.get(image_url, stream=True)
            response.raise_for_status() # Raise an HTTPError for bad responses (4xx or 5xx)

            # Save the image to the images directory
            with open(os.path.join('images', filename), 'wb') as file:
                for chunk in response.iter_content(1024):
                    file.write(chunk)
            print(f'Successfully downloaded cover for: {title}')
        except requests.exceptions.RequestException as e:
            print(f'Error downloading {title} from {image_url}: {e}')
    else:
        print(f'No image URL provided for {title}. Skipping.')

print('Download process finished.')